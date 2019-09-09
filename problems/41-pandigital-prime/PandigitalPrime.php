<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem41;

use tomtomsen\ProjectEuler\Problem;

final class PandigitalPrime implements Problem
{
    public function number() : int
    {
        return 41;
    }

    public function name() : string
    {
        return 'Pandigital prime';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            We shall say that an n-digit number is pandigital if it makes use of all the digits 1 to n exactly once. For example, 2143 is a 4-digit pandigital and is also prime.
            What is the largest n-digit pandigital prime that exists?
            DESCRIPTION;
    }

    public function run() : string
    {
        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $max = 0;

        while (1 < \count($numbers)) {
            foreach ($this->permutations($numbers) as $permutation) {
                $number = (int) \implode('', $permutation);

                if ($this->isPrime($number)) {
                    $max = \max($max, $number);
                }
            }
            \array_pop($numbers);
        }

        return "{$max}";
    }

    // https://stackoverflow.com/a/27160465
    private function permutations(array $elements) : \Generator
    {
        if (1 >= \count($elements)) {
            yield $elements;
        } else {
            foreach ($this->permutations(\array_slice($elements, 1)) as $permutation) {
                foreach (\range(0, \count($elements) - 1) as $i) {
                    yield
                        \array_merge(
                            \array_slice($permutation, 0, $i),
                            [$elements[0]],
                            \array_slice($permutation, $i)
                        );
                }
            }
        }
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
