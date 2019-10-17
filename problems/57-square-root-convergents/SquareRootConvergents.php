<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem57;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class SquareRootConvergents implements Problem
{
    public function number() : int
    {
        return 57;
    }

    public function name() : string
    {
        return 'Square root convergents';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            It is possible to show that the square root of two can be expressed as an infinite continued fraction.
            $\sqrt 2 =1+ \frac 1 {2+ \frac 1 {2 +\frac 1 {2+ \dots}}}$
            By expanding this for the first four iterations, we get:
            $1 + \frac 1 2 = \frac  32 = 1.5$
            $1 + \frac 1 {2 + \frac 1 2} = \frac 7 5 = 1.4$
            $1 + \frac 1 {2 + \frac 1 {2+\frac 1 2}} = \frac {17}{12} = 1.41666 \dots$
            $1 + \frac 1 {2 + \frac 1 {2+\frac 1 {2+\frac 1 2}}} = \frac {41}{29} = 1.41379 \dots$
            The next three expansions are $\frac {99}{70}$, $\frac {239}{169}$, and $\frac {577}{408}$, 
            but the eighth expansion, $\frac {1393}{985}$, is the first example where the number of digits 
            in the numerator exceeds the number of digits in the denominator.
            
            In the first one-thousand expansions, how many fractions contain a numerator with more digits than the denominator?
            DESCRIPTION;
    }

    public function run() : string
    {
        $count = 0;
        $x = [BigInteger::of('2'), BigInteger::one()];

        for ($i = 1; 1000 >= $i; ++$i) {
            $y = $this->divide([BigInteger::one(), BigInteger::one()], $x); // 1 / x
            $x = $this->add([BigInteger::of('2'), BigInteger::one()], $y); // 2 + y
            $a = $this->divide([BigInteger::one(), BigInteger::one()], $x); // 1 / x
            $result = $this->add([BigInteger::one(), BigInteger::one()], $a); // 2 + a

            if (\mb_strlen("{$result[0]}") > \mb_strlen("{$result[1]}")) {
                ++$count;
            }
        }

        return "{$count}";
    }

    private function add(array $a, array $b) : array
    {
        return [$a[0]->multipliedBy($b[1])->plus($b[0]->multipliedBy($a[1])), $a[1]->multipliedBy($b[1])];
    }

    private function divide(array $dividend, array $divisor) : array
    {
        return [$dividend[0]->multipliedBy($divisor[1]), $dividend[1]->multipliedBy($divisor[0])];
    }
}
