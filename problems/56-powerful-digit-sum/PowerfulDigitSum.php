<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem56;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class PowerfulDigitSum implements Problem
{
    public function number() : int
    {
        return 56;
    }

    public function name() : string
    {
        return 'Powerful digit sum';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            A googol (10100) is a massive number: one followed by one-hundred zeros; 100100 is almost unimaginably large: one followed by two-hundred zeros. Despite their size, the sum of the digits in each number is only 1.
            Considering natural numbers of the form, ab, where a, b < 100, what is the maximum digital sum?
            DESCRIPTION;
    }

    public function run() : string
    {
        $max = 0;

        for ($a = 1; 100 > $a; ++$a) {
            for ($b = 1; 100 > $b; ++$b) {
                $n = (string) BigInteger::of("{$a}")->power($b);
                $sum = 0;

                for ($i = 0; \mb_strlen($n) > $i; ++$i) {
                    $sum += (int) $n[$i];
                }
                $max = \max($max, $sum);
            }
        }

        return "{$max}";
    }
}
