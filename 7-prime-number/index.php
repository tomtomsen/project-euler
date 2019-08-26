<?php

namespace tomtomsen\ProjectEurler\MultipleOf3And5;

use SebastianBergmann\Timer\Timer;
use function assert;

require_once __DIR__ . '/../vendor/autoload.php';

const ANSWER = 104743;

Timer::start();
$primeNumber = findPrimeNumber(10001);
$time = Timer::stop();
assert($primeNumber === ANSWER, "assert $primeNumber === ANSWER");
echo "Answer: $primeNumber === " . ANSWER . PHP_EOL;
echo "Time: " . Timer::secondsToTimeString($time) . PHP_EOL;
echo Timer::resourceUsage() . PHP_EOL;

function findPrimeNumber($n)
{
    $iFound = 0;

    for ($i = 1; $iFound < $n; $i ++) {
        if (isPrime($i)) {
            $iFound ++;
        }
    }

    return $i - 1;
}

// https://stackoverflow.com/a/16763365
function isPrime($num)
{
    //1 is not prime. See: http://en.wikipedia.org/wiki/Prime_number#Primality_of_one
    if ($num == 1) {
        return false;
    }

    //2 is prime (the only even number that is prime)
    if ($num == 2) {
        return true;
    }

    /**
     * if the number is divisible by two, then it's not prime and it's no longer
     * needed to check other even numbers
     */
    if ($num % 2 == 0) {
        return false;
    }

    /**
     * Checks the odd numbers. If any of them is a factor, then it returns false.
     * The sqrt can be an aproximation, hence just for the sake of
     * security, one rounds it to the next highest integer value.
     */
    $ceil = ceil(sqrt($num));
    for ($i = 3; $i <= $ceil; $i = $i + 2) {
        if ($num % $i == 0) {
            return false;
        }
    }

    return true;
}
