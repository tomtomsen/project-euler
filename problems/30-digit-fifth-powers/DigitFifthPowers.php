<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem30;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class DigitFifthPowers implements Problem
{
    public function number() : int
    {
        return 30;
    }

    public function name() : string
    {
        return 'Digit fifth powers';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            Surprisingly there are only three numbers that can be written as the sum of fourth powers of their digits:
            1634 = 1**4 + 6**4 + 3**4 + 4**4
            8208 = 8**4 + 2**4 + 0**4 + 8**4
            9474 = 9**4 + 4**4 + 7**4 + 4**4
            As 1 = 1**4 is not a sum it is not included.
            The sum of these numbers is 1634 + 8208 + 9474 = 19316.
            Find the sum of all the numbers that can be written as the sum of fifth powers of their digits.
            DESCRIPTION;
    }

    /**
     * @see https://projecteuler.net/quote_post=475-06430e738024d4d4eac4d9f2553734c18a812d25
     * "
     * The maximum value for one digit is 9^5 = 59049. We can find out the maximum possible sum for a given number
     * of digits by multiplying 59049 with the number of digits.
     * Let's say we're gonna check the number 123456789.
     * That's 9 digits, so the maximum sum would be 9*59049 = 531441, which doesn't even come close to 123456789.
     * So we know we can forget about any number 9-digit number because we'll never be able to reach a big enough sum.
     * And it'll only get worse with larger numbers
     */
    public function run() : string
    {
        $found = 0;

        for ($i = 10; 59049 * 6 >= $i; ++$i) {
            $sum = BigInteger::zero();

            for ($j = 0; \mb_strlen("{$i}") > $j; ++$j) {
                $n = (int) (($i % 10 ** ($j + 1)) / 10 ** $j);
                $sum = $sum->plus(BigInteger::of("{$n}")->power(5));
            }

            if ("{$sum}" === "{$i}") {
                $found += $i;
            }
        }

        return "{$found}";
    }
}
