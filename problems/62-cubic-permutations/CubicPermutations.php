<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem62;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class CubicPermutations implements Problem
{
    public function number() : int
    {
        return 62;
    }

    public function name() : string
    {
        return 'Cubic permutations';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The cube, 41063625 (345^3), can be permuted to produce two other cubes: 
            56623104 (384^3) and 66430125 (405^3). 
            In fact, 41063625 is the smallest cube which has exactly three permutations of its digits which are also 
            cube.
            Find the smallest cube for which exactly five permutations of its digits are cube.
            DESCRIPTION;
    }

    public function run() : string
    {
        $length = 0;
        $cache = [];

        for ($i = 0; 8500 > $i; ++$i) {
            $n = (string) BigInteger::of("{$i}")->power(3);
            $sorted = $this->sort($n);

            if (\mb_strlen($n) > $length) {
                $length = \mb_strlen($n);
                $cache = [
                    $sorted => [$n],
                ];
            } elseif (!\array_key_exists($sorted, $cache)) {
                $cache[$sorted] = [$n];
            } else {
                $cache[$sorted][] = $n;

                if (5 === \count($cache[$sorted])) {
                    return $cache[$sorted][0];
                }
            }
        }

        throw new \RuntimeException('failed to find the solution');
    }

    private function sort(string $n) : string
    {
        $chars = \str_split($n);
        \sort($chars);

        return \implode('', $chars);
    }
}
