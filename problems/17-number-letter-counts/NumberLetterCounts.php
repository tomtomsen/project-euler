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
        $letterCount = 0;

        for ($i = 1; 1000 >= $i; ++$i) {
            $numberAsString = $this->numberToString($i);
            $numberAsStringWithoutSpaces = \preg_replace('~ ~', '', $numberAsString);

            if (null === $numberAsStringWithoutSpaces) {
                continue;
            }
            $letterCount += \mb_strlen($numberAsStringWithoutSpaces);
        }

        return "{$letterCount}";
    }

    private function numberToString(int $number) : string
    {
        $numberAsWord = [
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
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
        ];

        if (\array_key_exists($number, $numberAsWord)) {
            return $numberAsWord[$number];
        }

        $thousand = (int) ($number / 1000);

        $str = '';

        if (0 < $thousand) {
            $str .= $this->numberToString($thousand) . ' thousand';
        }

        $hundred = (int) (($number % 1000) / 100);

        if (0 < $hundred) {
            if (0 < $thousand) {
                $str .= ' and ';
            }
            $str .= $this->numberToString($hundred) . ' hundred';
        }

        $lastTwo = ($number % 100);
        $tenth = (int) ($lastTwo / 10);
        $single = (int) (($number % 10) / 1);

        if ((0 < $tenth || 0 < $single) && 0 < $hundred) {
            $str .= ' and ';
        }

        if (\array_key_exists($lastTwo, $numberAsWord)) {
            $str .= $numberAsWord[$lastTwo];
        } else {
            if (0 < $tenth) {
                $str .= $numberAsWord[$tenth * 10];
            }

            if (0 < $single) {
                if (0 < $tenth) {
                    $str .= ' ';
                }
                $str .= $this->numberToString($single);
            }
        }

        return "{$str}";
    }
}
