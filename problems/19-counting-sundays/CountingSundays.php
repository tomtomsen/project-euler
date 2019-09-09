<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem19;

use tomtomsen\ProjectEuler\Problem;

final class CountingSundays implements Problem
{
    public function number() : int
    {
        return 19;
    }

    public function name() : string
    {
        return 'Counting Sundays';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            You are given the following information, but you may prefer to do some research for yourself.
            1 Jan 1900 was a Monday.
            Thirty days has September,
            April, June and November.
            All the rest have thirty-one,
            Saving February alone,
            Which has twenty-eight, rain or shine.
            And on leap years, twenty-nine.
            A leap year occurs on any year evenly divisible by 4, but not on a century unless it is divisible by 400.
            How many Sundays fell on the first of the month during the twentieth century (1 Jan 1901 to 31 Dec 2000)?
            DESCRIPTION;
    }

    public function run() : string
    {
        $day = 1;
        $month = 1;
        $year = 1900;
        $months = $this->months($year);
        $dayofweek = 1; // monday
        $sundayCount = 0;

        while (2000 >= $year) {
            if (1901 <= $year && 7 === $dayofweek && 1 === $day) {
                ++$sundayCount;
            }

            $dayofweek = ($dayofweek % 7) + 1;
            ++$day;

            if ($day > $months[$month]) {
                if (12 === $month) {
                    ++$year;
                    $months = $this->months($year);
                }
                $month = ($month % 12) + 1;
                $day = 1;
            }
        }

        return "{$sundayCount}";
    }

    private function months(int $year) : array
    {
        return
            $months = [
                1 => 31,
                2 => $this->isLeapYear($year) ? 29 : 28,
                3 => 31,
                4 => 30,
                5 => 31,
                6 => 30,
                7 => 31,
                8 => 31,
                9 => 30,
                10 => 31,
                11 => 30,
                12 => 31,
            ];
    }

    private function isLeapYear(int $year) : bool
    {
        return (0 === ($year % 4)) && ((0 !== ($year % 100)) || (0 === ($year % 400)));
    }
}
