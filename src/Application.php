<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler;

use Symfony\Component\Console\Application as SymfonyApplication;

final class Application extends SymfonyApplication
{
    public function __construct()
    {
        parent::__construct('Project Euler', $this->getVersion());
    }

    public function getVersion()
    {
        return '1.0.0';
    }
}
