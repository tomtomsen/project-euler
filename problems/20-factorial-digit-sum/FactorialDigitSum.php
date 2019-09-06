<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem20;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class FactorialDigitSum implements Problem
{
    public function number() : int
    {
        return 20;
    }

    public function name() : string
    {
        return 'Factorial digit sum';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            n! means n × (n − 1) × ... × 3 × 2 × 1
            For example, 10! = 10 × 9 × ... × 3 × 2 × 1 = 3628800,and the sum of the digits in the number 10! is 3 + 6 + 2 + 8 + 8 + 0 + 0 = 27.
            Find the sum of the digits in the number 100!
            DESCRIPTION;
    }

    public function run() : string
    {
        $factorial = $this->factorial(BigInteger::of('100'));
        $factorialString = (string) $factorial;

        $sum = 0;

        for ($i = 0; \mb_strlen($factorialString) > $i; ++$i) {
            $sum += (int) $factorialString[$i];
        }

        return "{$sum}";
    }

    private function factorial(BigInteger $n) : BigInteger
    {
        if (0 === $n->toInt()) {
            return BigInteger::one();
        }

        return $n->multipliedBy($this->factorial($n->minus(1)));
    }
}
