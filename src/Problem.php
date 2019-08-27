<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler;

interface Problem
{
    public function url() : string;

    public function name() : string;

    public function description() : string;

    public function number() : int;

    public function run() : string;
}
