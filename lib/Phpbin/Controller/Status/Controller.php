<?php

namespace Phpbin\Controller\Status;

use Phpbin\Web\Application;
use Symfony\Component\HttpFoundation\Request;
use Phpbin\Component\HttpFoundation\JsonResponse;

class Controller
{
    public function executeIndex(Application $app, Request $request)
    {
        $code = $request->get('code');
        $headers = array();
        $params = $request->query->all();
        foreach ($params as $key => $value) {
            $fkey = implode('-', array_map('ucfirst', explode('-', $key)));
            $headers[$fkey] = $value;
        }
        return new JsonResponse(null, $code, $headers);
    }
}