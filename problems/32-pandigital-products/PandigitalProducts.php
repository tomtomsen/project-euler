<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem32;

use tomtomsen\ProjectEuler\Problem;

final class PandigitalProducts implements Problem
{
    public function number() : int
    {
        return 32;
    }

    public function name() : string
    {
        return 'Pandigital products';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            We shall say that an n-digit number is pandigital if it makes use of all the digits 1 to n exactly once; for example, the 5-digit number, 15234, is 1 through 5 pandigital.
            
            The product 7254 is unusual, as the identity, 39 × 186 = 7254, containing multiplicand, multiplier, and product is 1 through 9 pandigital.
            
            Find the sum of all products whose multiplicand/multiplier/product identity can be written as a 1 through 9 pandigital.
            
            HINT: Some products can be obtained in more than one way so be sure to only include it once in your sum.
            DESCRIPTION;
    }

    public function run() : string
    {
        $productCache = [];

        for ($i = 1; 99 >= $i; ++$i) {
            for ($j = 100; 9999 >= $j; ++$j) {
                $product = $i * $j;
                $str = "{$i}{$j}{$product}";
                $numbers = \str_split($str);
                \sort($numbers);

                if ('123456789' === \implode('', $numbers) && !\array_key_exists("{$product}", $productCache)) {
                    $productCache["{$product}"] = $product;
                }
            }
        }

        return '' . \array_sum($productCache);
    }
}
