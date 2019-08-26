<?php

namespace tomtomsen\ProjectEurler\MultipleOf3And5;

use SebastianBergmann\Timer\Timer;
use function assert;

require_once __DIR__ . '/../vendor/autoload.php';

const ANSWER = 25164150;

Timer::start();
$sum = sumSquareDifference(100);
$time = Timer::stop();
assert($sum === ANSWER, "assert $sum === ANSWER");
echo "Answer: $sum === " . ANSWER . PHP_EOL;
echo "Time: " . Timer::secondsToTimeString($time) . PHP_EOL;
echo Timer::resourceUsage() . PHP_EOL;

function sumSquareDifference(int $n)
{
    $square = 0;
    $sum = 0;
    for ($i = 1; $i <= $n; $i++) {
        $square += $i * $i;
        $sum += $i;
    }

    return $sum * $sum - $square;
}
