<?php

namespace test\Phpbin;

use Phpbin\Controller\Controller;
use Phpbin\Test\ContainerAwareTest;
use Symfony\Component\HttpFoundation\Request;

class ControllerTest extends ContainerAwareTest
{
    public function setUp()
    {
        $this->controller = new Controller();
        parent::setUp();
    }

    /**
     * @dataProvider appRequest
     */
    public function testIp(Request $request)
    {
        $response = $this->controller->executeIp($this->app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('origin', $body);
        $this->assertEquals($body['origin'], '127.0.0.1');
    }

    /**
     * @dataProvider appRequest
     */
    public function testUserAgent(Request $request)
    {
        $userAgent = 'PHPUnit';
        $request = clone $request;
        $request->headers->set('User-Agent', $userAgent);
        $response = $this->controller->executeUserAgent($this->app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('user-agent', $body);
        $this->assertEquals($body['user-agent'], $userAgent);
    }

    /**
     * @dataProvider appRequest
     */
    public function testHeaders(Request $request)
    {
        $request = clone $request;
        $request->headers->set('x-foo', 'bar');
        $response = $this->controller->executeHeaders($this->app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('headers', $body);
        $this->assertGreaterThan(0, count($body['headers']));
        $this->assertArrayHasKey('X-Foo', $body['headers']);
    }

    /**
     * @dataProvider appRequest
     */
    public function testResponseHeaders(Request $request)
    {
        $request = clone $request;
        $request->query->set('X-Foo', 'bar');
        $response = $this->controller->executeResponseHeaders($this->app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('X-Foo', $body);
        $this->assertTrue($response->headers->has('X-Foo'));
    }
}