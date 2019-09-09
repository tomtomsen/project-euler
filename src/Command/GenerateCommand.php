<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use tomtomsen\ProjectEuler\Problem;
use tomtomsen\ProjectEuler\ProblemClassGenerator\ProblemClassGenerator;
use tomtomsen\ProjectEuler\ProblemImporter\ProblemImporter;

final class GenerateCommand extends SymfonyCommand
{
    public const ARGUMENT_PROBLEM = 'problem';
    public const OPTION_DIRECTORY = 'directory';
    public const OPTION_DIRECTORY_SHORTCUT = 'd';

    /** @var ProblemClassGenerator */
    private $classGenerator;

    /** @var ProblemImporter */
    private $problemImporter;

    public function __construct(
        ProblemImporter $importer,
        ProblemClassGenerator $classGenerator,
        string $name = null
    ) {
        $this->problemImporter = $importer;
        $this->classGenerator = $classGenerator;

        parent::__construct($name);
    }

    protected function configure() : void
    {
        $this
            ->addArgument(
                self::ARGUMENT_PROBLEM,
                InputArgument::REQUIRED,
                'The problem number'
            )
            ->addOption(
                self::OPTION_DIRECTORY,
                self::OPTION_DIRECTORY_SHORTCUT,
                InputOption::VALUE_OPTIONAL,
                'Directory to save problem',
                \realpath('problems')
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $problemNr = $input->getArgument(self::ARGUMENT_PROBLEM);

        if (!\is_numeric($problemNr)) {
            throw new \RuntimeException('problemNr expected to be numeric');
        }
        $problemNr = (int) $problemNr;
        $baseDirectory = $input->getOption(self::OPTION_DIRECTORY);

        if (\is_array($baseDirectory)) {
            $baseDirectory = \end($baseDirectory);
        }

        $problem = $this->problemImporter->import($problemNr);
        $classTpl = $this->classGenerator->generate($problem);

        $dir = $this->getDirectory((string) $baseDirectory, $problem);

        if (\file_exists($dir)) {
            throw new \RuntimeException('directory ' . $dir . ' already exists');
        }
        \mkdir($dir, 0755, true);

        \file_put_contents(
            /** @phan-suppress-next-line PhanParamSuspiciousOrder */
            \strtr(
                '{dir}/{file}.php',
                [
                    '{dir}' => $dir,
                    '{file}' => \preg_replace('/ /', '', $problem->name()),
                ]
            ),
            $classTpl
        );

        $io = new SymfonyStyle($input, $output);
        $io->block("Problem {$problemNr} imported", null, 'fg=black;bg=green', ' ', true);

        return 0;
    }

    protected function getDirectory(string $baseDir, Problem $problem) : string
    {
        /** @phan-suppress-next-line PhanParamSuspiciousOrder */
        return \strtr(
            '{dir}/{nr}-{title}',
            [
                '{dir}' => \rtrim($baseDir, '/'),
                '{nr}' => $problem->number(),
                '{title}' => \mb_strtolower(\strtr($problem->name(), [' ' => '-'])),
            ]
        );
    }
}
