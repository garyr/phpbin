<?php
namespace test\Phpbin\Auth;

use Phpbin\Controller\Auth\Controller;
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
    public function testBasicAuth(Request $request)
    {
        $request = clone $request;
        $user = 'phpunit';
        $password = sprintf('phpunit%d', mt_rand(1000, 9999));
        $request->request->set('user', $user);
        $request->request->set('passwd', $password);
        $response = $this->controller->executeBasicAuth(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);

        $this->assertEquals($response->getStatusCode(), 401);
        $this->assertTrue($response->headers->has('WWW-Authenticate'));

        // re-request authorization with bad credentials
        $header = sprintf('Basic %s', base64_encode(sprintf('%s:%s456', $user, $password)));
        $request->headers->set('Authorization', $header);
        $response = $this->controller->executeBasicAuth(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('authenticated', $body);
        $this->assertFalse($body['authenticated']);

        // re-request authorization with good credentials
        $header = sprintf('Basic %s', base64_encode(sprintf('%s:%s', $user, $password)));
        $request->headers->set('Authorization', $header);
        $response = $this->controller->executeBasicAuth(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('authenticated', $body);
        $this->assertArrayHasKey('user', $body);
        $this->assertTrue($body['authenticated']);
        $this->assertEquals($user, $body['user']);
    }
}