<?php

namespace tomtomsen\ProjectEurler\MultipleOf3And5;

use SebastianBergmann\Timer\Timer;
use function assert;

require_once __DIR__ . '/../vendor/autoload.php';

const ANSWER = 6857;

Timer::start();
$sum = largestPrimeFactor(600851475143);
$time = Timer::stop();
assert($sum === ANSWER, "assert $sum === ANSWER");
echo "Answer: $sum === " . ANSWER . PHP_EOL;
echo "Time: " . Timer::secondsToTimeString($time) . PHP_EOL;
echo Timer::resourceUsage() . PHP_EOL;

function largestPrimeFactor($n)
{
    $primeFactors = primeFactors($n);
    return max($primeFactors);
}

function primeFactors($n)
{
    $factors = [];
    // Print the number of
    // 2s that divide n
    while ($n % 2 == 0) {
        $factors[] = 2;
        $n = $n / 2;
    }

    // n must be odd at this
    // point. So we can skip
    // one element (Note i = i +2)
    for ($i = 3; $i <= sqrt($n);
                   $i = $i + 2) {

        // While i divides n,
        // print i and divide n
        while ($n % $i == 0) {
            $factors[] = $i;
            $n = $n / $i;
        }
    }

    // This condition is to
    // handle the case when n
    // is a prime number greater
    // than 2
    if ($n > 2) {
        $factors[] = $n;
    }
    return $factors;
}
