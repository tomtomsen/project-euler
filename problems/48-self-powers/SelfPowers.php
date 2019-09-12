<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem48;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class SelfPowers implements Problem
{
    public function number() : int
    {
        return 48;
    }

    public function name() : string
    {
        return 'Self powers';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The series, 1**1 + 2**2 + 3**3 + ... + 10**10 = 10405071317.
            Find the last ten digits of the series, 1**1 + 2**2 + 3**3 + ... + 1000**1000.
            DESCRIPTION;
    }

    public function run() : string
    {
        $i = 1;
        $sum = BigInteger::zero();

        for ($i = 1; 1000 >= $i; ++$i) {
            $sum = $sum->plus(BigInteger::of("{$i}")->power($i));
            $sum = BigInteger::of(\mb_substr("{$sum}", -10));
        }

        return "{$sum}";
    }
}
