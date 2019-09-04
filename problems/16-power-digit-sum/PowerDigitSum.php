<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem16;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class PowerDigitSum implements Problem
{
    public function number() : int
    {
        return 16;
    }

    public function name() : string
    {
        return 'Power digit sum';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            215 = 32768 and the sum of its digits is 3 + 2 + 7 + 6 + 8 = 26.
            What is the sum of the digits of the number 2^1000?
            DESCRIPTION;
    }

    public function run() : string
    {
        $number = (string) BigInteger::of('2')->power(1000);
        $sum = 0;

        for ($i = 0; \mb_strlen($number) > $i; ++$i) {
            $sum += (int) $number[$i];
        }

        return "{$sum}";
    }
}
