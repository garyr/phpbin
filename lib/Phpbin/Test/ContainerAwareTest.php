<?php

namespace Phpbin\Test;

use Phpbin\Web\Application;
use Symfony\Component\HttpFoundation\Request;

abstract class ContainerAwareTest extends \PHPUnit_Framework_TestCase
{
    protected static $app;

    protected $controller;

    public static function setUpBeforeClass()
    {
        self::$app = new Application();
    }

    public static function tearDownAfterClass()
    {
        self::$app = null;
    }

    public function appRequest()
    {
        $request = new Request();
        return array(
            array($request)
        );
    }
}