<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem3;

use tomtomsen\ProjectEuler\Problem;

final class LargestPrimeFactor implements Problem
{
    public const NUMBER = 600851475143;

    public function number() : int
    {
        return 3;
    }

    public function url() : string
    {
        return 'https://projecteuler.net/problem=3';
    }

    public function name() : string
    {
        return 'Largest prime factor';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The prime factors of 13195 are 5, 7, 13 and 29.
            What is the largest prime factor of the number 600851475143 ?
            DESCRIPTION;
    }

    public function run() : string
    {
        $n = self::NUMBER;
        $factors = [];
        // Print the number of
        // 2s that divide n
        while (0 === $n % 2) {
            $factors[] = 2;
            $n = $n / 2;
        }

        // n must be odd at this
        // point. So we can skip
        // one element (Note i = i +2)
        for ($i = 3; \sqrt($n) >= $i;
              $i = $i + 2) {
            // While i divides n,
            // print i and divide n
            while (0 === $n % $i) {
                $factors[] = $i;
                $n = $n / $i;
            }
        }

        // This condition is to
        // handle the case when n
        // is a prime number greater
        // than 2
        if (2 < $n) {
            $factors[] = $n;
        }

        return '' . \max($factors);
    }
}
