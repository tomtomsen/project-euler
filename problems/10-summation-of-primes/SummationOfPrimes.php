<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem10;

use tomtomsen\ProjectEuler\Problem;

final class SummationOfPrimes implements Problem
{
    public function number() : int
    {
        return 10;
    }

    public function name() : string
    {
        return 'Summation of primes';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The sum of the primes below 10 is 2 + 3 + 5 + 7 = 17.
            Find the sum of all the primes below two million.
            DESCRIPTION;
    }

    public function run() : string
    {
        $sum = 0;

        for ($i = 1; 2000000 > $i; ++$i) {
            if ($this->isPrime($i)) {
                $sum += $i;
            }
        }

        return '' . $sum;
    }

    // https://stackoverflow.com/a/16763365
    private function isPrime($num)
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
