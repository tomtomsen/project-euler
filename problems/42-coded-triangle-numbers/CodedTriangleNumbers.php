<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem42;

use tomtomsen\ProjectEuler\Problem;

final class CodedTriangleNumbers implements Problem
{
    public function number() : int
    {
        return 42;
    }

    public function name() : string
    {
        return 'Coded triangle numbers';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The nth term of the sequence of triangle numbers is given by, tn = ½n(n+1); so the first ten triangle numbers are:
            1, 3, 6, 10, 15, 21, 28, 36, 45, 55, ...
            By converting each letter in a word to a number corresponding to its alphabetical position and adding these values we form a word value. For example, the word value for SKY is 19 + 11 + 25 = 55 = t10. If the word value is a triangle number then we shall call the word a triangle word.
            Using words.txt (right click and 'Save Link/Target As...'), a 16K text file containing nearly two-thousand common English words, how many are triangle words?
            DESCRIPTION;
    }

    public function run() : string
    {
        $names = $this->readNames(__DIR__ . '/p042_words.txt');
        $triangles = $this->generateTriangleNumbers(20);

        $triangleCount = 0;

        foreach ($names as $name) {
            $sum = 0;

            for ($idx = 0; \mb_strlen($name) > $idx; ++$idx) {
                $sum += $this->numberOfLetter($name[$idx]);
            }

            if (\in_array($sum, $triangles, true)) {
                ++$triangleCount;
            }
        }

        return "{$triangleCount}";
    }

    private function readNames(string $path) : array
    {
        $content = \file_get_contents($path);

        if (false === $content) {
            throw new \RuntimeException('cant read file');
        }

        $nameString = \preg_replace('~[^,A-Z]~', '', $content);

        if (null === $nameString) {
            throw new \RuntimeException('failed to improve string');
        }

        return \explode(',', $nameString);
    }

    private function generateTriangleNumbers(int $count) : array
    {
        $triangles = [];

        for ($i = 0; $i < $count; ++$i) {
            $triangles[] = $this->triangle($i);
        }

        return $triangles;
    }

    private function triangle(int $n) : int
    {
        return (int) (0.5 * $n * ($n + 1));
    }

    private function numberOfLetter(string $char) : int
    {
        return \ord($char) - \ord('A') + 1;
    }
}
