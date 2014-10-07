<?php
namespace test\Phpbin\Status;

use Phpbin\Controller\Status\Controller;
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
        $code = 418;
        $request->request->set('code', $code);
        $response = $this->controller->executeIndex($this->app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals($code, $response->getStatusCode());
    }

    /**
     * @dataProvider appRequest
     */
    public function testHeaders(Request $request)
    {
        $request = clone $request;
        $code = 302;
        $request->request->set('code', $code);
        $location = 'http://example.com';
        $request->query->set('Location', $location);
        $response = $this->controller->executeIndex($this->app, $request);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals($code, $response->getStatusCode());
        $this->assertTrue($response->headers->has('Location'));
        $this->assertEquals($location, $response->headers->get('Location'));
    }
}