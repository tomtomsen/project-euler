<?php

namespace tomtomsen\ProjectEurler\MultipleOf3And5;

use SebastianBergmann\Timer\Timer;
use function assert;

require_once __DIR__ . '/../vendor/autoload.php';

const ANSWER = 233168;

Timer::start();
$sum = arithmeticProgessionApproach(1000);
$time = Timer::stop();
assert($sum === ANSWER, "assert $sum === ANSWER");
echo "Answer: $sum === " . ANSWER . PHP_EOL;
echo "Time: " . Timer::secondsToTimeString($time) . PHP_EOL;
echo Timer::resourceUsage() . PHP_EOL;

// O(N)
// Time: ~0.0004
function forApproach($max) {
    $sum = 0;
    for($i = 1; $i < $max; $i++) {
        if ($i % 3 === 0 || $i % 5 === 0) {
            $sum += $i;
        }
    }
    return $sum;
}

// Time: ~0.00017
function sumApproach($max) {
    $sum = 0;
    for($i = 3; $i < $max; $i += 3) {
        $sum += $i;
    }

    for($i = 5; $i < $max; $i += 5) {
        $sum += $i;
    }

    for ($i = 15; $i < $max; $i += 15) {
        $sum -= $i;
    }

    return $sum;
}

// Time: 1.78^e-5
// https://projecteuler.net/thread=1#103
// arithmetic progressions
function arithmeticProgessionApproach($max) {
    return (int) (
        1.5 * (int)(($max-1)/3) * (int)(($max+2)/3) 
      + 2.5*(int)(($max-1)/5)*(int)(($max+4)/5) 
      - 7.5*(int)(($max-1)/15)*(int)(($max+14)/15)
    );
}