<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem37;

use tomtomsen\ProjectEuler\Problem;

final class TruncatablePrimes implements Problem
{
    public function number() : int
    {
        return 37;
    }

    public function name() : string
    {
        return 'Truncatable primes';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The number 3797 has an interesting property. Being prime itself, it is possible to continuously remove digits from left to right, and remain prime at each stage: 3797, 797, 97, and 7. Similarly we can work from right to left: 3797, 379, 37, and 3.
            Find the sum of the only eleven primes that are both truncatable from left to right and right to left.
            NOTE: 2, 3, 5, and 7 are not considered to be truncatable primes.
            DESCRIPTION;
    }

    public function run() : string
    {
        $sum = 0;

        for ($n = 11, $i = 0; 11 > $i; ++$n) {
            if ($this->isTruncablePrime($n)) {
                $sum += $n;
                ++$i;
            }
        }

        return "{$sum}";
    }

    private function isTruncablePrime(int $num) : bool
    {
        if (!$this->isPrime($num)) {
            return false;
        }

        $numStr = "{$num}";

        for ($i = \mb_strlen($numStr); 1 < $i; --$i ) {
            if (!$this->isPrime((int) \mb_substr($numStr, 0, $i - 1))
            || !$this->isPrime((int) \mb_substr($numStr, -$i + 1, $i - 1))) {
                return false;
            }
        }

        return true;
    }

    // https://stackoverflow.com/a/16763365
    private function isPrime(int $num) : bool
    {
        //1 is not prime. See: http://en.wikipedia.org/wiki/Prime_number#Primality_of_one
        if (1 === $num) {
            return false;
        }

        //2 is prime (the only even number that is prime)
        if (2 === $num) {
            return true;
        }

        /**
         * if the number is divisible by two, then it's not prime and it's no longer
         * needed to check other even numbers.
         */
        if (0 === $num % 2) {
            return false;
        }

        /**
         * Checks the odd numbers. If any of them is a factor, then it returns false.
         * The sqrt can be an aproximation, hence just for the sake of
         * security, one rounds it to the next highest integer value.
         */
        $ceil = \ceil(\sqrt($num));

        for ($i = 3; $i <= $ceil; $i = $i + 2) {
            if (0 === $num % $i) {
                return false;
            }
        }

        return true;
    }
}
