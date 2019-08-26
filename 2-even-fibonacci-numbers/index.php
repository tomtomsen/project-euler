<?php

namespace tomtomsen\ProjectEurler\MultipleOf3And5;

use SebastianBergmann\Timer\Timer;
use function assert;

require_once __DIR__ . '/../vendor/autoload.php';

const ANSWER = 4613732;

Timer::start();
$sum = evenFibonacciNumbers();
$time = Timer::stop();
assert($sum === ANSWER, "assert $sum === ANSWER");
echo "Answer: $sum === " . ANSWER . PHP_EOL;
echo "Time: " . Timer::secondsToTimeString($time) . PHP_EOL;
echo Timer::resourceUsage() . PHP_EOL;

function evenFibonacciNumbers()
{
    $evenFibonacciSum = 0;
    $fibSum = 0;
    for ($i = 0, $j = 1; $fibSum < 4000000;) {
        $fibSum = $i + $j;
        $i = $j;
        $j = $fibSum;

        if ($fibSum % 2 === 0) {
            $evenFibonacciSum += $fibSum;
        }
    }
    return $evenFibonacciSum;
}
