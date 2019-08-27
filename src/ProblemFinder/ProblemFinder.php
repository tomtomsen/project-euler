<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemFinder;

use tomtomsen\ProjectEuler\Problem;

interface ProblemFinder
{
    /**
     * @return Problem[]
     */
    public function find() : array;
}
