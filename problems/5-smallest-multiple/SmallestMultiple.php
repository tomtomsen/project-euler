<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem4;

use tomtomsen\ProjectEuler\Problem;

final class SmallestMultiple implements Problem
{
    public function number() : int
    {
        return 5;
    }

    public function name() : string
    {
        return 'Smallest multiple';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            2520 is the smallest number that can be divided by each of the numbers from 1 to 10 without any remainder.
            What is the smallest positive number that is evenly divisible by all of the numbers from 1 to 20?
            DESCRIPTION;
    }

    public function run() : string
    {
        for ($i = 20; 0 < $i; $i += 20) {
            $j = 0;

            for ($j = 19; 0 < $j; --$j) {
                if (0 !== $i % $j) {
                    break;
                }
            }

            if (0 === $j) {
                return "{$i}";
            }
        }

        throw new \RuntimeException('failed to find a solution');
    }
}
