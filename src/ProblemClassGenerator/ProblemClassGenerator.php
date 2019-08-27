<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemClassGenerator;

interface ProblemClassGenerator
{
    public function generate(int $number, string $name, string $description = '') : string;
}
