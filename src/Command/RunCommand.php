<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Command;

use Nette\Neon\Neon;
use SebastianBergmann\Timer\Timer;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use tomtomsen\ProjectEuler\Problem;
use tomtomsen\ProjectEuler\ProblemFinder\ProblemFinder;

final class RunCommand extends SymfonyCommand
{
    public const ARGUMENT_PROBLEM = 'problem';

    /** @var ProblemFinder */
    private $finder;

    public function __construct(ProblemFinder $finder, string $name = null)
    {
        $this->finder = $finder;

        parent::__construct($name);
    }

    protected function configure() : void
    {
        $this
            ->addArgument(self::ARGUMENT_PROBLEM, InputArgument::OPTIONAL, 'Run this specific problem', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $problemNr = $input->getArgument(self::ARGUMENT_PROBLEM);

        if (!\is_numeric($problemNr)) {
            throw new \RuntimeException(self::ARGUMENT_PROBLEM . ' expected to be numeric');
        }
        $problemNr = (int) $problemNr;

        $io = new SymfonyStyle($input, $output);

        $problems = $this->finder->find();
        \usort($problems, static function (Problem $problemA, Problem $problemB) {
            return $problemA->number() - $problemB->number();
        });

        $choices = [];
        $problemsByName = [];
        $problemsByNumber = [];

        foreach ($problems as $problem) {
            $choices[$problem->number()] = $problem->name();
            $problemsByNumber[$problem->number()] = $problem;
            $problemsByName[$problem->name()] = $problem;
        }

        if (\array_key_exists($problemNr, $problemsByNumber)) {
            $problem = $problemsByNumber[$problemNr];
        } else {
            $question = new ChoiceQuestion(
                'Please select your problem',
                $choices,
                0
            );
            $question->setErrorMessage('Problem %s is invalid.');

            $problemChoice = $io->askQuestion($question);
            $problem = $problemsByName[$problemChoice];
        }

        $io->title($problem->name());
        $io->text("https://projecteuler.net/problem={$problem->number()}");
        $io->block(
            $problem->description(),
            null,
            null,
            '   ',
        );

        Timer::start();
        $result = $problem->run();
        $time = Timer::stop();

        $expectedAnswer = null;

        if (\file_exists('.answers') && \is_readable('.answers')) {
            $fileContent = \file_get_contents('.answers');

            if (false !== $fileContent) {
                $answers = Neon::decode($fileContent);

                if (\array_key_exists('answers', $answers) && \array_key_exists($problemNr, $answers['answers'])) {
                    $expectedAnswer = $answers['answers'][$problemNr];
                }
            }
        }

        if ($expectedAnswer) {
            if ($result === "{$expectedAnswer}") {
                $io->block("Answer: {$result}", null, 'fg=black;bg=green', '  ', true);
            } else {
                $io->block("Answer: {$result} (expected {$expectedAnswer})", null, 'fg=white;bg=red', '  ', true);
            }
        } else {
            $io->block("Answer: {$result}", null, 'fg=black;bg=white', '  ', true);
        }

        $io->block('(Time: ' . Timer::secondsToTimeString($time) . ')');

        return 0;
    }
}
