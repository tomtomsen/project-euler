<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemFinder;

interface ProblemFinder
{
    /**
     * @return Problem[]
     */
    public function find() : array;
}
