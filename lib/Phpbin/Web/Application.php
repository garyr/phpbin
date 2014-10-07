<?php

namespace Phpbin\Web;

use Silex;
use Phpbin\Application\ApplicationTrait;
use Phpbin\Extension\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application extends Silex\Application
{
    use ApplicationTrait;

    public function __construct(array $values = array())
    {
        parent::__construct($values);
        $this->initContainer();
    }

    public function initialize()
    {
        $app_root_dir = $this->getContainer()->getParameter('app_root_dir');

        $this->getContainer()->registerExtension(new Route);
        $this->getLoader()->load($app_root_dir . '/config/routes.yml');

        // bind controllers
        foreach ($this->getContainer()->getExtensionConfig('routes')[0] as $name => $route) {
            $controller = $this->match($route['pattern'], $route['controller']);
            $controller->method($route['requirements']['_method']);
            $controller->bind($name);
        }

        $this->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => $app_root_dir.'/views',
        ));

        $this->after(array($this, 'onAfterRequest'));

        return $this;
    }

    public function run(Request $request = null)
    {
        $this->initialize();
        parent::run($request);
    }

    public function onAfterRequest(Request $request, Response $response)
    {
        if ($this->isJson($response->getContent())) {
            $response->headers->set('Content-Type', 'application/json');
        }
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}