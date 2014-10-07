<?php

namespace Phpbin\Test;

use Phpbin\Web\Application;
use Symfony\Component\HttpFoundation\Request;

abstract class ContainerAwareTest extends \PHPUnit_Framework_TestCase
{
    protected $app;
    protected $controller;

    public function setUp()
    {
        $this->app = new Application();
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