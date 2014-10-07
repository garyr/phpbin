<?php

namespace Phpbin\Test;

use Phpbin\Web\Application;
use Phpbin\Application\ApplicationTrait;
use Symfony\Component\HttpFoundation\Request;

abstract class ContainerAwareTest extends \PHPUnit_Framework_TestCase
{
    use ApplicationTrait;

    protected $app;
    protected $controller;

    public function setUp()
    {
        $this->initContainer();
        $this->app = new Application();
        $this->app->setContainer($this->getContainer());
        parent::setUp();
    }

    public function appRequest()
    {
        $request = new Request();
        return array(
            array($request)
        );
    }
}