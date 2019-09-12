<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem43;

use tomtomsen\ProjectEuler\Problem;

final class SubstringDivisibility implements Problem
{
    public function number() : int
    {
        return 43;
    }

    public function name() : string
    {
        return 'Sub-string divisibility';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The number, 1406357289, is a 0 to 9 pandigital number because it is made up of each of the digits 0 to 9 in some order, but it also has a rather interesting sub-string divisibility property.
            Let d1 be the 1st digit, d2 be the 2nd digit, and so on. In this way, we note the following:
            d2d3d4=406 is divisible by 2
            d3d4d5=063 is divisible by 3
            d4d5d6=635 is divisible by 5
            d5d6d7=357 is divisible by 7
            d6d7d8=572 is divisible by 11
            d7d8d9=728 is divisible by 13
            d8d9d10=289 is divisible by 17
            Find the sum of all 0 to 9 pandigital numbers with this property.
            DESCRIPTION;
    }

    public function run() : string
    {
        $sum = 0;

        foreach ($this->permutations(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']) as $permutation) {
            $d234 = (int) ($permutation[1] . $permutation[2] . $permutation[3]);
            $d345 = (int) ($permutation[2] . $permutation[3] . $permutation[4]);
            $d456 = (int) ($permutation[3] . $permutation[4] . $permutation[5]);
            $d567 = (int) ($permutation[4] . $permutation[5] . $permutation[6]);
            $d678 = (int) ($permutation[5] . $permutation[6] . $permutation[7]);
            $d789 = (int) ($permutation[6] . $permutation[7] . $permutation[8]);
            $d890 = (int) ($permutation[7] . $permutation[8] . $permutation[9]);

            if (
                0 === $d234 % 2
                && 0 === $d345 % 3
                && 0 === $d456 % 5
                && 0 === $d567 % 7
                && 0 === $d678 % 11
                && 0 === $d789 % 13
                && 0 === $d890 % 17
            ) {
                $sum += (int) \implode('', $permutation);
            }
        }

        return "{$sum}";
    }

    // https://stackoverflow.com/a/27160465
    private function permutations(array $elements) : \Generator
    {
        if (1 >= \count($elements)) {
            yield $elements;
        } else {
            foreach ($this->permutations(\array_slice($elements, 1)) as $permutation) {
                foreach (\range(0, \count($elements) - 1) as $i) {
                    yield
                    \array_merge(
                        \array_slice($permutation, 0, $i),
                        [$elements[0]],
                        \array_slice($permutation, $i)
                    );
                }
            }
        }
    }
}
