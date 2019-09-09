<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem36;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class DoubleBasePalindromes implements Problem
{
    public function number() : int
    {
        return 36;
    }

    public function name() : string
    {
        return 'Double-base palindromes';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The decimal number, 585 = 10010010012 (binary), is palindromic in both bases.
            Find the sum of all numbers, less than one million, which are palindromic in base 10 and base 2.
            (Please note that the palindromic number, in either base, may not include leading zeros.)
            DESCRIPTION;
    }

    public function run() : string
    {
        $n = 0;

        for ($i = 1; 1000000 > $i; ++$i) {
            if (\strrev("{$i}") === "{$i}") {
                $binary = BigInteger::of("{$i}")->toBase(2);

                if (\strrev($binary) === $binary) {
                    $n += $i;
                }
            }
        }

        return "{$n}";
    }
}
