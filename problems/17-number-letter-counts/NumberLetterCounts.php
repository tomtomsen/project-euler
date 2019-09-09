<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem17;

use tomtomsen\ProjectEuler\Problem;

final class NumberLetterCounts implements Problem
{
    public function number() : int
    {
        return 17;
    }

    public function name() : string
    {
        return 'Number letter counts';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            If the numbers 1 to 5 are written out in words: one, two, three, four, five, then there are 3 + 3 + 5 + 4 + 4 = 19 letters used in total.
            If all the numbers from 1 to 1000 (one thousand) inclusive were written out in words, how many letters would be used? 
            NOTE: Do not count spaces or hyphens. For example, 342 (three hundred and forty-two) contains 23 letters and 115 (one hundred and fifteen) contains 20 letters. The use of "and" when writing out numbers is in compliance with British usage.
            DESCRIPTION;
    }

    public function run() : string
    {
        $sum = 0;

        for ($i = 1; 1000 >= $i; ++$i) {
            $numberWithWords = $this->numberToWords($i);
            echo "{$i}: {$numberWithWords}" . \PHP_EOL;
            $onlyLetters = \preg_replace('~[^a-z]~', '', $numberWithWords);
            $sum += \mb_strlen($onlyLetters);
        }

        return "{$sum}";
    }

    private function numberToWords(int $number) : string
    {
        $baseNumbersAsString = [
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            15 => 'fifteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            80 => 'eighty',
            90 => 'ninety',
            1000 => 'one thousand',
        ];

        if (\array_key_exists($number, $baseNumbersAsString)) {
            return $baseNumbersAsString[$number];
        }
        $str = '';

        $hunderth = (int) ($number / 100);
        $tenth = (int) ($number / 10);

        if (0 < $hunderth) {
            $tenth = (int) (($number % 100) / 10);
            $str .= $baseNumbersAsString[$hunderth] . 'hundred';
        }

        if (0 === $tenth) { // zehnerstelle
            if (0 !== $number % 10) {
                $str .= $baseNumbersAsString[$number % 10];
            }
        } else {
            if (1 === $tenth) {
                if (0 < $hunderth) {
                    $str .= ' and ';
                }

                if (\array_key_exists('1' . $number % 10, $baseNumbersAsString)) {
                    $str .= $baseNumbersAsString['1' . $number % 10];
                } else {
                    $str .= $baseNumbersAsString[$number % 10] . 'teen';
                }
            } else {
                if (0 < $hunderth) {
                    $str .= ' and ';
                }

                if (\array_key_exists($tenth * 10, $baseNumbersAsString)) {
                    $str .= $baseNumbersAsString[$tenth * 10];
                } else {
                    $str .= $baseNumbersAsString[$tenth] . 'ty';
                }
                $str .= $baseNumbersAsString[$number % 10];
            }
        }

        return $str;
    }
}
