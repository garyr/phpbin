<?php

namespace Phpbin\Controller;

use Phpbin\Web\Application;
use Phpbin\Web\ResponseTrait;
use Symfony\Component\HttpFoundation\Request;
use Phpbin\Component\HttpFoundation\JsonResponse;

class Controller
{
    use ResponseTrait;

    public function executeIndex(Application $app, Request $request)
    {
        return $app['twig']->render('index.twig', array());
    }

    public function executeIp(Application $app, Request $request)
    {
        return new JsonResponse($this->getOrigin($request), 200);
    }

    public function executeUserAgent(Application $app, Request $request)
    {
        return new JsonResponse($this->getUserAgent($request), 200);
    }

    public function executeHeaders(Application $app, Request $request)
    {
        return new JsonResponse($this->getHeaders($request), 200);
    }

    public function executeResponseHeaders(Application $app, Request $request)
    {
        $headers = array();
        $params = $request->query->all();
        foreach ($params as $key => $value) {
            $fkey = implode('-', array_map('ucfirst', explode('-', $key)));
            $headers[$fkey] = $value;
        }
        return new JsonResponse($headers, 200, $headers);
    }
}
