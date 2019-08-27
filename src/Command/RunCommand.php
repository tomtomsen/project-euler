<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Command;

use SebastianBergmann\Timer\Timer;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use tomtomsen\ProjectEuler\Problem;
use tomtomsen\ProjectEuler\ProblemFinder\ProblemFinder;

final class RunCommand extends SymfonyCommand
{
    /** @var ProblemFinder */
    private $finder;

    public function __construct(ProblemFinder $finder, string $name = null)
    {
        $this->finder = $finder;

        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $choices = [];
        $problemsByName = [];
        $problems = $this->finder->find();
        \usort($problems, static function (Problem $problemA, Problem $problemB) {
            return $problemA->number() - $problemB->number();
        });

        foreach ($problems as $problem) {
            $choices[$problem->number()] = $problem->name();
            $problemsByName[$problem->name()] = $problem;
            $output->writeln('<info>  ' . $problem->number() . '. ' . $problem->name() . '</info>');
        }

        $question = new ChoiceQuestion(
            'Please select your problem',
            $choices,
            0
        );
        $question->setErrorMessage('Problem %s is invalid.');

        $io = new SymfonyStyle($input, $output);
        $problemChoice = $io->askQuestion($question);
        $problem = $problemsByName[$problemChoice];

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

        $io->success('Answer: ' . $result);
        $io->comment('Time: ' . Timer::secondsToTimeString($time));
    }
}
