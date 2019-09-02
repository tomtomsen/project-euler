<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Command;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use tomtomsen\ProjectEuler\ProblemClassGenerator\ProblemClassGenerator;

final class GenerateCommand extends SymfonyCommand
{
    public const ARGUMENT_PROBLEM = 'problem';
    public const OPTION_DIRECTORY = 'directory';

    /** @var ClientInterface */
    private $client;

    /** @var ProblemClassGenerator */
    private $classGenerator;

    public function __construct(ClientInterface $client, ProblemClassGenerator $classGenerator, string $name = null)
    {
        $this->client = $client;
        $this->classGenerator = $classGenerator;

        parent::__construct($name);
    }

    protected function configure() : void
    {
        $this
            ->addArgument(self::ARGUMENT_PROBLEM, InputArgument::REQUIRED, 'The problem number')
            ->addOption(self::OPTION_DIRECTORY, 'd', InputOption::VALUE_OPTIONAL, 'Directory to save problem', \realpath(__DIR__ . '/../../problems'));
    }

    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $problemNr = (int) $input->getArgument(self::ARGUMENT_PROBLEM);
        $baseDirectory = $input->getOption(self::OPTION_DIRECTORY);

        if (\is_array($baseDirectory)) {
            $baseDirectory = \reset($baseDirectory);
        }

        $output->writeln('Opening ' . $this->url($problemNr));

        $psr17Factory = new Psr17Factory();
        $request = $psr17Factory->createRequest('GET', $this->url($problemNr));

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw $e;
        }

        $crawler = new Crawler((string) $response->getBody());
        $title = $crawler->filter('body h2')->first()->text();
        $description = $crawler->filter('body .problem_content')->first()->text();

        $classTpl = $this->classGenerator->generate($problemNr, $title, $description);

        $dir = $this->getDirectory((string) $baseDirectory, $problemNr, $title);

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
                    '{file}' => \preg_replace('/ /', '', $title),
                ]
            ),
            $classTpl
        );
    }

    protected function url(int $problem)
    {
        /** @phan-suppress-next-line PhanParamSuspiciousOrder */
        return \strtr(
            'https://projecteuler.net/problem={problem}',
            [
                '{problem}' => $problem,
            ]
        );
    }

    protected function getDirectory(string $baseDir, int $problemNr, string $title) : string
    {
        /** @phan-suppress-next-line PhanParamSuspiciousOrder */
        return \strtr(
            '{dir}/{nr}-{title}',
            [
                '{dir}' => \rtrim($baseDir, '/'),
                '{nr}' => $problemNr,
                '{title}' => \mb_strtolower(\strtr($title, [' ' => '-'])),
            ]
        );
    }
}
