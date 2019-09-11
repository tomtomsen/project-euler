<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem35;

use tomtomsen\ProjectEuler\Problem;

final class CircularPrimes implements Problem
{
    public function number() : int
    {
        return 35;
    }

    public function name() : string
    {
        return 'Circular primes';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The number, 197, is called a circular prime because all rotations of the digits: 197, 971, and 719, are themselves prime.
            There are thirteen such primes below 100: 2, 3, 5, 7, 11, 13, 17, 31, 37, 71, 73, 79, and 97.
            How many circular primes are there below one million?
            DESCRIPTION;
    }

    public function run() : string
    {
        $primes = [];

        for ($i = 0; 1000000 > $i; ++$i) {
            if ($this->isPrime($i)) {
                $primes[$i] = $i;
            }
        }

        $circularPrimeCount = 0;

        foreach ($primes as $prime) {
            if ($this->isCircularPrime((string) $prime, $primes)) {
                ++$circularPrimeCount;
            }
        }

        return "{$circularPrimeCount}";
    }

    private function isCircularPrime(string $prime, array $primes) : bool
    {
        for ($x = 0; \mb_strlen($prime) - 1 > $x; ++$x) {
            $prime = $this->shift($prime);

            if (!\array_key_exists((int) $prime, $primes)) {
                return false;
            }
        }

        return true;
    }

    private function shift(string $str) : string
    {
        $strlen = \mb_strlen($str);

        if (1 >= $strlen) {
            throw new \RuntimeException('string expected to be at least 2 characters long');
        }

        $tmp = $str[0];

        for ($i = 1; $i < $strlen; ++$i) {
            $str[$i - 1] = $str[$i];
        }
        $str[$strlen - 1] = $tmp;

        return $str;
    }

    private function isPrime(int $num) : bool
    {
        if (1 === $num) {
            return false;
        }

        if (2 === $num) {
            return true;
        }

        if (0 === $num % 2) {
            return false;
        }

        $ceil = \ceil(\sqrt($num));

        for ($i = 3; $i <= $ceil; $i = $i + 2) {
            if (0 === $num % $i) {
                return false;
            }
        }

        return true;
    }
}
