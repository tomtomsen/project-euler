<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemImporter;

use tomtomsen\ProjectEuler\Problem;

interface ProblemImporter
{
    public function import(int $number) : Problem;
}
