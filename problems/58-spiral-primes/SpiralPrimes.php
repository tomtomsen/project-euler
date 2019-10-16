<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem58;

use tomtomsen\ProjectEuler\Problem;

final class SpiralPrimes implements Problem
{
    public function number() : int
    {
        return 58;
    }

    public function name() : string
    {
        return 'Spiral primes';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            Starting with 1 and spiralling anticlockwise in the following way, a square spiral with side length 7 is formed.
            37 36 35 34 33 32 31
            38 17 16 15 14 13 30
            39 18  5  4  3 12 29
            40 19  6  1  2 11 28
            41 20  7  8  9 10 27
            42 21 22 23 24 25 26
            43 44 45 46 47 48 49
            
            It is interesting to note that the odd squares lie along the bottom right diagonal, but what is more interesting is that 8 out of the 13 numbers lying along both diagonals are prime; that is, a ratio of 8/13 ≈ 62%.
            If one complete new layer is wrapped around the spiral above, a square spiral with side length 9 will be formed. If this process is continued, what is the side length of the square spiral for which the ratio of primes along both diagonals first falls below 10%?
            
            DESCRIPTION;
    }

    public function run() : string
    {
        $n = 1;
        $primeCount = 0;
        $diagnoalNumbers = 1;

        for ($i = 2, $boxSize = 3; 26242 > $i; $i += 2, $boxSize += 2) {
            for ($j = 0; 4 > $j; $j++, $diagnoalNumbers++) {
                $n += $i;

                if ($this->isPrime($n)) {
                    ++$primeCount;
                }
            }

            if (0.1 > $primeCount / $diagnoalNumbers) {
                return "{$boxSize}";
            }
        }

        throw new \RuntimeException('problem couldnt be solved');
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
