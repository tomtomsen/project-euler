<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem9;

use tomtomsen\ProjectEuler\Problem;

final class SpecialPythagoreanTriplet implements Problem
{
    public function number() : int
    {
        return 9;
    }

    public function name() : string
    {
        return 'Special Pythagorean triplet';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            A Pythagorean triplet is a set of three natural numbers, a < b < c, for which,
             a² + b² = c²
            For example, 3² + 4² = 9 + 16 = 25 = 5².
            There exists exactly one Pythagorean triplet for which a + b + c = 1000.
            Find the product abc.
            DESCRIPTION;
    }

    public function run() : string
    {
        throw new \RuntimeException('not implemented yet');
    }
}
