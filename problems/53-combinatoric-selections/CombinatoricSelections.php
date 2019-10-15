<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem53;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class CombinatoricSelections implements Problem
{
    private $factorials;

    public function number() : int
    {
        return 53;
    }

    public function name() : string
    {
        return 'Combinatoric selections';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            There are exactly ten ways of selecting three from five, 12345:
            123, 124, 125, 134, 135, 145, 234, 235, 245, and 345
            In combinatorics, we use the notation, $\displaystyle \binom 5 3 = 10$.
            In general, $\displaystyle \binom n r = \dfrac{n!}{r!(n-r)!}$, where $r \le n$, $n! = n \times (n-1) \times ... \times 3 \times 2 \times 1$, and $0! = 1$.
            
            It is not until $n = 23$, that a value exceeds one-million: $\displaystyle \binom {23} {10} = 1144066$.
            How many, not necessarily distinct, values of $\displaystyle \binom n r$ for $1 \le n \le 100$, are greater than one-million?
            DESCRIPTION;
    }

    public function run() : string
    {
        $this->factorials = [
            BigInteger::one(),
        ];

        for ($i = 1; 100 >= $i; ++$i) {
            $this->factorials[$i] = $this->factorials[$i - 1]->multipliedBy("{$i}");
        }

        $count = 0;

        for ($n = 1; 100 >= $n; ++$n) {
            for ($r = 0; $r <= $n; ++$r) {
                $over = $this->over($n, $r);

                if ($over->isGreaterThan('1000000')) {
                    ++$count;
                }
            }
        }

        return "{$count}";
    }

    private function over($n, $r) : BigInteger
    {
        return $this->factorials[$n]->dividedBy(
            $this->factorials[$r]->multipliedBy(
                $this->factorials[$n - $r]
            )
        );
    }
}
