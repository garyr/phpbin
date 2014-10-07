<?php
namespace test\Phpbin\Cookies;

use Phpbin\Controller\Cookies\Controller;
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
    public function testIndex(Request $request)
    {
        $request = clone $request;
        $request->cookies->set('foo', 'bar');
        $response = $this->controller->executeIndex(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('cookies', $body);
        $this->assertEquals(1, count($body['cookies']));
        $this->assertArrayHasKey('foo', $body['cookies']);
        $this->assertEquals('bar', $body['cookies']['foo']);
    }

    /**
     * @dataProvider appRequest
     */
    public function testSet(Request $request)
    {
        $request = clone $request;
        $request->query->set('foo', 'bar');
        $response = $this->controller->executeSet(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue($response->headers->has('Set-Cookie'));
        $this->assertEquals('foo=bar', $response->headers->get('Set-Cookie'));
        $this->assertTrue($response->headers->has('Location'));
        $this->assertEquals('/cookies', $response->headers->get('Location'));
    }

    /**
     * @dataProvider appRequest
     */
    public function testDelete(Request $request)
    {
        $request = clone $request;
        $request->query->set('foo', 'bar');
        $response = $this->controller->executeDelete(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue($response->headers->has('Set-Cookie'));
        $this->assertEquals('foo=; Expires=Thu, 01 Jan 1970 00:00:00 GMT', $response->headers->get('Set-Cookie'));
        $this->assertTrue($response->headers->has('Location'));
        $this->assertEquals('/cookies', $response->headers->get('Location'));
    }
}