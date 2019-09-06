<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem22;

use tomtomsen\ProjectEuler\Problem;

final class NamesScores implements Problem
{
    public function number() : int
    {
        return 22;
    }

    public function name() : string
    {
        return 'Names scores';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            Using names.txt (right click and 'Save Link/Target As...'), a 46K text file containing over five-thousand first names, begin by sorting it into alphabetical order. Then working out the alphabetical value for each name, multiply this value by its alphabetical position in the list to obtain a name score.
            For example, when the list is sorted into alphabetical order, COLIN, which is worth 3 + 15 + 12 + 9 + 14 = 53, is the 938th name in the list. So, COLIN would obtain a score of 938 × 53 = 49714.
            What is the total of all the name scores in the file?
            DESCRIPTION;
    }

    public function run() : string
    {
        \assert(53 === $this->calculateNameValue('COLIN'));

        $nameFile = __DIR__ . '/p022_names.txt';
        $nameFileContent = \file_get_contents($nameFile);

        if (false === $nameFileContent) {
            throw new \RuntimeException("cannot read file '{$nameFile}'");
        }
        $nameFileContent = \preg_replace('~[^,A-Z]~', '', $nameFileContent);

        if (null === $nameFileContent) {
            throw new \RuntimeException('failed to execute preg_replace');
        }
        $names = \explode(',', $nameFileContent);
        \sort($names);

        $sum = 0;

        foreach ($names as $i => $name) {
            $nameValue = $this->calculateNameValue($name);
            $sum = $sum + $nameValue * ($i + 1);
        }

        return (string) $sum;
    }

    private function calculateNameValue(string $name) : int
    {
        $sum = 0;

        for ($i = 0; \mb_strlen($name) > $i; ++$i) {
            $sum += \ord($name[$i]) - 64;
        }

        return $sum;
    }
}
