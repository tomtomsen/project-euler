<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem25;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class ThausendDigitFibonacciNumber implements Problem
{
    public function number() : int
    {
        return 25;
    }

    public function name() : string
    {
        return '1000-digit Fibonacci number';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The Fibonacci sequence is defined by the recurrence relation:
            Fn = Fn−1 + Fn−2, where F1 = 1 and F2 = 1.
            Hence the first 12 terms will be:
            F1 = 1
            F2 = 1
            F3 = 2
            F4 = 3
            F5 = 5
            F6 = 8
            F7 = 13
            F8 = 21
            F9 = 34
            F10 = 55
            F11 = 89
            F12 = 144
            The 12th term, F12, is the first term to contain three digits.
            What is the index of the first term in the Fibonacci sequence to contain 1000 digits?
            DESCRIPTION;
    }

    public function run() : string
    {
        $i = BigInteger::one();
        $j = BigInteger::one();
        $fi = BigInteger::of('2');

        while (1000 > \mb_strlen((string) $j)) {
            $tmp = $i;
            $i = $j;
            $j = $tmp->plus($i);
            $fi = $fi->plus('1');
        }

        return (string) $fi;
    }
}
