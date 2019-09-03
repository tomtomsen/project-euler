<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem14;

use tomtomsen\ProjectEuler\Problem;

final class LongestCollatzSequence implements Problem
{
    public function number() : int
    {
        return 14;
    }

    public function name() : string
    {
        return 'Longest Collatz sequence';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The following iterative sequence is defined for the set of positive integers:
            n → n/2 (n is even)n → 3n + 1 (n is odd)
            Using the rule above and starting with 13, we generate the following sequence:
            13 → 40 → 20 → 10 → 5 → 16 → 8 → 4 → 2 → 1
            It can be seen that this sequence (starting at 13 and finishing at 1) contains 10 terms. Although it has not been proved yet (Collatz Problem), it is thought that all starting numbers finish at 1.
            Which starting number, under one million, produces the longest chain?
            NOTE: Once the chain starts the terms are allowed to go above one million.
            DESCRIPTION;
    }

    public function run() : string
    {
        $max = 0;
        $numberWithLongestChain = 1;

        for ($num = 1; 1000000 > $num; ++$num) {
            $elements = 1;
            $sequenceElement = $num;

            while (1 !== $sequenceElement) {
                ++$elements;

                if (0 === $sequenceElement % 2) {
                    $sequenceElement = $sequenceElement / 2;
                } else {
                    $sequenceElement = 3 * $sequenceElement + 1;
                }
            }

            if ($elements > $max) {
                $max = $elements;
                $numberWithLongestChain = $num;
            }
        }

        return "{$numberWithLongestChain}";
    }
}
