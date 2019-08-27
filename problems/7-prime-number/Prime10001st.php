<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem4;

use tomtomsen\ProjectEuler\Problem;

final class Prime10001st implements Problem
{
    public const PRIME_NUMBER = 10001;

    public function number() : int
    {
        return 7;
    }

    public function name() : string
    {
        return '10001st prime';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            By listing the first six prime numbers: 2, 3, 5, 7, 11, and 13, we can see that the 6th prime is 13.
            What is the 10 001st prime number?
            DESCRIPTION;
    }

    public function run() : string
    {
        $iFound = 0;
        $i = 0;

        for ($i = 1; self::PRIME_NUMBER > $iFound; ++$i) {
            if ($this->isPrime($i)) {
                ++$iFound;
            }
        }

        return '' . ($i - 1);
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
