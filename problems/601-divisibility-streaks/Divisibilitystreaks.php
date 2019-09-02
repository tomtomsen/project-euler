<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem601;

use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;
use tomtomsen\ProjectEuler\Problem;

final class Divisibilitystreaks implements Problem
{
    /** @var bool */
    private $debug = false;

    public function number() : int
    {
        return 601;
    }

    public function name() : string
    {
        return 'Divisibility streaks';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            For every positive number $n$ we define the function  $streak(n)=k$   as the smallest positive integer $k$ such that $n+k$ is not divisible by $k+1$.
            E.g:
            13 is divisible by 1 
            14 is divisible by 2 
            15 is divisible by 3 
            16 is divisible by 4 
            17 is NOT divisible by 5 
            So $streak(13) = 4$.  
            Similarly:
            120 is divisible by 1 
            121 is NOT divisible by 2 
            So $streak(120) = 1$.
            
            
            Define $P(s, N)$ to be the number of integers $n$, $1 < n < N$, for which $streak(n) = s$.
            So $P(3, 14) = 1$ and $P(6, 10^6) = 14286$.
            
            
            Find the sum, as $i$ ranges from 1 to 31, of $P(i, 4^i)$.
            DESCRIPTION;
    }

    public function run() : string
    {
        $base = 4;

        $cache = [
            2 => BigInteger::of('2'),
        ];
        $p = [
            '1' => BigInteger::of('1'),
        ];

        for ($i = 2; 31 >= $i; ++$i) {
            $max = BigInteger::of("{$base}")->power($i);
            echo "streak: {$i}, max: {$max} ({$base}^{$i})" . \PHP_EOL;

            $n1 = null;

            if (isset($cache[$i])) {
                $this->debug("{$i} found in cache - " . $cache[$i]);
                $n1_prev = $cache[$i];

                $p1 = 0;

                for (
                    $n = BigInteger::of('1')->multipliedBy($n1_prev)->plus('1'),
                    $j = 2;
                    $n->isLessThan($max);
                    $n = BigInteger::of("{$j}")->multipliedBy($n1_prev)->plus('1'),
                    $j++
                ) {
                    $this->debug("check: {$n}");
                    $s = $this->streak($n);

                    if ($s >= $i) {
                        if ($s === $i) {
                            // $this->debug("adding: $n");
                        } else {
                            if (0 === $p1) {
                                $p1 = $j;
                            } else {
                                $p2 = $j;
                                $stepsize = $p2 - $p1;
                                $times = $max->minus('1')->dividedBy($n1_prev, RoundingMode::DOWN);
                                $d = $times->minus($times->dividedBy("{$stepsize}", RoundingMode::DOWN));
                                $p[$i] = $d;
                                echo "ABORT@{$i}! stepsize: {$stepsize}, {$d} added " . \PHP_EOL;

                                break;
                            }

                            if (!isset($cache[$s])) {
                                $this->debug("remember: {$n} in streak {$s}");
                                $cache[$s] = $n->minus('1');
                            } else {
                                $this->debug("already remembered streak {$s}");
                            }
                        }
                    }
                }
            } else {
                $this->debug("{$i} not in cache");
            }
        }

        echo 'Cache: ' . \PHP_EOL;

        foreach ($cache as $key => $value) {
            echo "  {$key}: {$value->plus('1')}" . \PHP_EOL;
        }

        echo 'P: ' . \PHP_EOL;
        $sum = BigInteger::of('0');

        foreach ($p as $key => $value) {
            echo "  P({$key}, {$base}^{$key}): {$value}" . \PHP_EOL;
            $sum = $sum->plus(BigInteger::of($value));
        }

        // 1617243
        return "{$sum}";
    }

    private function streak(BigInteger $n) : int
    {
        if (0 === ($n->and('1')->toInt())) {
            return 1;
        }

        $k = 1;

        while ($n->minus('1')->plus("{$k}")->remainder("{$k}")->isEqualTo('0')) {
            ++$k;
        }

        return $k - 1;
    }

    private function debug(string $msg) : void
    {
        if ($this->debug) {
            echo '> ' . $msg . \PHP_EOL;
        }
    }
}
