<?php

namespace tomtomsen\ProjectEurler\MultipleOf3And5;

use SebastianBergmann\Timer\Timer;
use function assert;

require_once __DIR__ . '/../vendor/autoload.php';

const ANSWER = 232792560;

Timer::start();
$smallestMultiple = smallestMultiple();
$time = Timer::stop();
assert($smallestMultiple === ANSWER, "assert $smallestMultiple === ANSWER");
echo "Answer: $smallestMultiple === " . ANSWER . PHP_EOL;
echo "Time: " . Timer::secondsToTimeString($time) . PHP_EOL;
echo Timer::resourceUsage() . PHP_EOL;

function smallestMultiple()
{
    for ($i = 20; $i > 0; $i += 20) {
        for ($j = 19; $j > 0; $j--) {
            if ($i % $j !== 0) {
                break;
            }
        }

        if ($j === 0) {
            return $i;
        }
    }

    return 0;
}
