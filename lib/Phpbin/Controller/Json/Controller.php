<?php

namespace Phpbin\Controller\Json;

use Phpbin\Web\Application;
use Phpbin\Web\ResponseTrait;
use Phpbin\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
    use ResponseTrait;

    public function executeIndex(Application $app, Request $request)
    {
        $code = intval($request->get('code'));
        if (!is_int($code) || $code < 100) {
            $code = 200;
        }

        $response = [];
        $args = $request->query->all();
        $response = array_merge($response, $args);

        // json data
        if ($json = json_decode($request->getContent(), true)) {
            $response = array_merge($response, $json);
        }

        return new JsonResponse($response, $code);
    }
}
