<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem2;

use tomtomsen\ProjectEuler\Problem;

final class EvenFibonacciNumbers implements Problem
{
    public function number() : int
    {
        return 2;
    }

    public function url() : string
    {
        return 'https://projecteuler.net/problem=2';
    }

    public function name() : string
    {
        return 'Even Fibonacci numbers';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            Each new term in the Fibonacci sequence is generated by adding the previous two terms. By starting with 1 and 2, the first 10 terms will be:
            1, 2, 3, 5, 8, 13, 21, 34, 55, 89, ...
            By considering the terms in the Fibonacci sequence whose values do not exceed four million, find the sum of the even-valued terms.
            DESCRIPTION;
    }

    public function run() : string
    {
        $evenFibonacciSum = 0;
        $fibSum = 0;

        for ($i = 0, $j = 1; 4000000 > $fibSum;) {
            $fibSum = $i + $j;
            $i = $j;
            $j = $fibSum;

            if (0 === $fibSum % 2) {
                $evenFibonacciSum += $fibSum;
            }
        }

        return "{$evenFibonacciSum}";
    }
}
