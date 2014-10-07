<?php
namespace test\Phpbin\HttpVerb;

use Phpbin\Controller\HttpVerb\Controller;
use Phpbin\Test\ContainerAwareTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    public function testDelete(Request $request)
    {
        $request = clone $request;
        $request->setMethod('DELETE');
        $app_root_dir = self::$app->getContainer()->getParameter('app_root_dir');
        $UploadedFile = new UploadedFile($app_root_dir . '/phpunit.xml', 'phpunit.xml');
        $request->files->set('filename', $UploadedFile);
        $response = $this->controller->executeDelete(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('files', $body);
        $this->assertArrayHasKey('filename', $body['files']);
        $this->assertEquals(file_get_contents($app_root_dir . '/phpunit.xml'), $body['files']['filename']);
    }

    /**
     * @dataProvider appRequest
     */
    public function testGet(Request $request)
    {
        $request = clone $request;
        $request->query->set('foo', 'bar');
        $request->headers->set('x-foo', 'bar');
        $response = $this->controller->executeGet(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('args', $body);
        $this->assertArrayHasKey('headers', $body);
        $this->assertArrayHasKey('origin', $body);
        $this->assertArrayHasKey('url', $body);
        $this->assertInternalType('array', $body['args']);
        $this->assertGreaterThan(0, count($body['args']));
        $this->assertGreaterThan(0, count($body['headers']));
        $this->assertNotEmpty($body['origin']);
        $this->assertNotEmpty($body['url']);
    }

    /**
     * @dataProvider appRequest
     */
    public function testPatch(Request $request)
    {
        $request = clone $request;
        $request->setMethod('PATCH');
        $app_root_dir = self::$app->getContainer()->getParameter('app_root_dir');
        $UploadedFile = new UploadedFile($app_root_dir . '/phpunit.xml', 'phpunit.xml');
        $request->files->set('filename', $UploadedFile);
        $response = $this->controller->executePatch(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('files', $body);
        $this->assertArrayHasKey('filename', $body['files']);
        $this->assertEquals(file_get_contents($app_root_dir . '/phpunit.xml'), $body['files']['filename']);
    }

    /**
     * @dataProvider appRequest
     */
    public function testPost(Request $request)
    {
        $request = clone $request;
        $request->setMethod('POST');
        $app_root_dir = self::$app->getContainer()->getParameter('app_root_dir');
        $UploadedFile = new UploadedFile($app_root_dir . '/phpunit.xml', 'phpunit.xml');
        $request->files->set('filename', $UploadedFile);
        $response = $this->controller->executePost(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('files', $body);
        $this->assertArrayHasKey('filename', $body['files']);
        $this->assertEquals(file_get_contents($app_root_dir . '/phpunit.xml'), $body['files']['filename']);
    }

    /**
     * @dataProvider appRequest
     */
    public function testPut(Request $request)
    {
        $request = clone $request;
        $request->setMethod('PUT');
        $app_root_dir = self::$app->getContainer()->getParameter('app_root_dir');
        $UploadedFile = new UploadedFile($app_root_dir . '/phpunit.xml', 'phpunit.xml');
        $request->files->set('filename', $UploadedFile);
        $response = $this->controller->executePut(self::$app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertNotEmpty($response->getContent());
        $body = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse($body);
        $this->assertArrayHasKey('files', $body);
        $this->assertArrayHasKey('filename', $body['files']);
        $this->assertEquals(file_get_contents($app_root_dir . '/phpunit.xml'), $body['files']['filename']);
    }
}