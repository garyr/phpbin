<?php

namespace Phpbin\Controller\Content;

use Phpbin\Web\Application;
use Symfony\Component\HttpFoundation\Request;
use Phpbin\Component\HttpFoundation\JsonResponse;

class Controller
{
    public function executeBody(Application $app, Request $request)
    {
        $length = $request->get('length');
        $headers = array();
        $headers['Content-Length'] = $length;
        $jsonKey = 'body';

        // make json string is the same as length
        $jsonOffset = strlen(json_encode(array($jsonKey => ''), JSON_FORCE_OBJECT | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $response = array('body' => str_repeat('e', $length - $jsonOffset));

        return new JsonResponse($response, 200, $headers);
    }
}
