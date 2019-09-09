<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemImporter\Exception;

final class ProblemNotFound extends \RuntimeException
{
    public function __construct(int $number, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct("Problem {$number} not found", $code, $previous);
    }
}
