<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemImporter;

final class Problem implements \tomtomsen\ProjectEuler\Problem
{
    /** @var int */
    private $number;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    public function __construct(int $number, string $name, string $description)
    {
        $this->number = $number;
        $this->name = $name;
        $this->description = $description;
    }

    public function number() : int
    {
        return $this->number;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function description() : string
    {
        return $this->description;
    }

    public function run() : string
    {
        throw new \RuntimeException('Problem cannot be executed');
    }
}
