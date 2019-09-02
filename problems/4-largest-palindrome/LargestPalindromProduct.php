<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem4;

use tomtomsen\ProjectEuler\Problem;

final class LargestPalindromProduct implements Problem
{
    public function number() : int
    {
        return 4;
    }

    public function name() : string
    {
        return 'Largest palindrome product';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            A palindromic number reads the same both ways. The largest palindrome made from the product of two 2-digit numbers is 9009 = 91 × 99.
            Find the largest palindrome made from the product of two 3-digit numbers.
            DESCRIPTION;
    }

    public function run() : string
    {
        $max = [0, 0, 0];

        for ($i = 999; 99 < $i; --$i) {
            for ($j = 999; 99 < $j; --$j) {
                $multiple = $i * $j;

                if (\strrev("{$multiple}") === "{$multiple}") {
                    if ($multiple > $max[2]) {
                        $max = [$i, $j, $multiple];
                    }
                }
            }
        }

        return '' . $max[2];
    }
}
