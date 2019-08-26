<?php

namespace tomtomsen\ProjectEurler\MultipleOf3And5;

use SebastianBergmann\Timer\Timer;
use function assert;

require_once __DIR__ . '/../vendor/autoload.php';

const ANSWER = 906609;

Timer::start();
$sum = largestPalindrome();
$time = Timer::stop();
assert($sum === ANSWER, "assert $sum === ANSWER");
echo "Answer: $sum === " . ANSWER . PHP_EOL;
echo "Time: " . Timer::secondsToTimeString($time) . PHP_EOL;
echo Timer::resourceUsage() . PHP_EOL;

function largestPalindrome()
{
    $multiple = 0;
    $max = [0, 0, 0];
    for ($i = 999; $i > 99; $i--) {
        for ($j = 999; $j > 99; $j --) {
            $multiple = $i * $j;

            if ("$multiple" === strrev("$multiple")) {
                if ($multiple > $max[2]) {
                    $max = [$i, $j, $multiple];
                }
            }
        }
    }

    return $max[2];
}
