<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem21;

use tomtomsen\ProjectEuler\Problem;

final class AmicableNumbers implements Problem
{
    public function number() : int
    {
        return 21;
    }

    public function name() : string
    {
        return 'Amicable numbers';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            Let d(n) be defined as the sum of proper divisors of n (numbers less than n which divide evenly into n).
            If d(a) = b and d(b) = a, where a ≠ b, then a and b are an amicable pair and each of a and b are called amicable numbers.
            For example, the proper divisors of 220 are 1, 2, 4, 5, 10, 11, 20, 22, 44, 55 and 110; therefore d(220) = 284. The proper divisors of 284 are 1, 2, 4, 71 and 142; so d(284) = 220.
            Evaluate the sum of all the amicable numbers under 10000.
            DESCRIPTION;
    }

    public function run() : string
    {
        $sum = [];

        for ($i = 1; 10000 > $i; ++$i) {
            $d = $this->d($i);
            $u = $this->d($d);

            if ($u === $i && $d !== $i) {
                $sum[$d] = $d;
                $sum[$i] = $i;
            }
        }

        return '' . \array_sum($sum);
    }

    private function d(int $n) : int
    {
        $sum = 0;

        foreach ($this->dividors($n) as $i) {
            $sum += $i;
        }

        return $sum;
    }

    private function dividors(int $n) : \Generator
    {
        for ($i = 1; $i < $n; ++$i) {
            if (0 === $n % $i) {
                yield $i;
            }
        }
    }
}
