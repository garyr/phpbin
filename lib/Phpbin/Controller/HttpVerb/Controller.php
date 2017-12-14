<?php

namespace Phpbin\Controller\HttpVerb;

use Phpbin\Web\Application;
use Phpbin\Web\ResponseTrait;
use Symfony\Component\HttpFoundation\Request;
use Phpbin\Component\HttpFoundation\JsonResponse;

class Controller
{
    use ResponseTrait;

    public function executeDelete(Application $app, Request $request)
    {
        return $this->handleData($app, $request);
    }

    public function executeGet(Application $app, Request $request)
    {
        return new JsonResponse($this->getBasicResponse($request), 200);
    }

    public function executePatch(Application $app, Request $request)
    {
        return $this->handleData($app, $request);
    }

    public function executePost(Application $app, Request $request)
    {
        return $this->handleData($app, $request);
    }

    public function executePut(Application $app, Request $request)
    {
        return $this->handleData($app, $request);
    }
}
