<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler;

interface Problem
{
    public function number() : int;

    public function name() : string;

    public function description() : string;

    public function run() : string;
}
