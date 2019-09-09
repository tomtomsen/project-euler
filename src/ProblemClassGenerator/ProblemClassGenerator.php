<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemClassGenerator;

use tomtomsen\ProjectEuler\Problem;

interface ProblemClassGenerator
{
    public function generate(Problem $problem) : string;
}
