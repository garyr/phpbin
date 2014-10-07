<?php

namespace Phpbin\Console;

use Phpbin\Application\ApplicationTrait;
use Symfony\Component\Console;

class Application extends Console\Application
{
    use ApplicationTrait;

    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);
        $this->initContainer();
    }
}