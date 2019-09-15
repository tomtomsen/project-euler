<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem52;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class PermutedMultiples implements Problem
{
    public function number() : int
    {
        return 52;
    }

    public function name() : string
    {
        return 'Permuted multiples';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            It can be seen that the number, 125874, and its double, 251748, contain exactly the same digits, but in a different order.
            Find the smallest positive integer, x, such that 2x, 3x, 4x, 5x, and 6x, contain the same digits.
            DESCRIPTION;
    }

    public function run() : string
    {
        for ($i = BigInteger::one(), $j = 0; 1000000 > $j; $j++, $i = $i->plus('1')) {
            $baseDigits = $this->digits((string) $i);

            $two = $i->multipliedBy(2);
            $twoDigits = $this->digits((string) $two);

            if ($baseDigits !== $twoDigits) {
                continue;
            }

            $three = $i->multipliedBy(3);
            $threeDigits = $this->digits((string) $three);

            if ($baseDigits !== $threeDigits) {
                continue;
            }

            $four = $i->multipliedBy(4);
            $fourDigits = $this->digits((string) $four);

            if ($baseDigits !== $fourDigits) {
                continue;
            }

            $five = $i->multipliedBy(5);
            $fiveDigits = $this->digits((string) $five);

            if ($baseDigits !== $fiveDigits) {
                continue;
            }

            $six = $i->multipliedBy(6);
            $sixDigits = $this->digits((string) $six);

            if ($baseDigits === $sixDigits) {
                return "{$i}";
            }
        }

        throw new \RuntimeException('number not found');
    }

    private function digits(string $n) : string
    {
        $baseNumbers = \str_split($n);
        \sort($baseNumbers);
        $baseNumbers = \array_unique($baseNumbers);

        return \implode('', $baseNumbers);
    }
}
