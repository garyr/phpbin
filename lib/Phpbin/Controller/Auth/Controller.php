<?php

namespace Phpbin\Controller\Auth;

use Phpbin\Web\Application;
use Symfony\Component\HttpFoundation\Request;
use Phpbin\Component\HttpFoundation\JsonResponse;

class Controller
{
    public function executeBasicAuth(Application $app, Request $request)
    {
        if (!$request->headers->has('Authorization')) {
            return new JsonResponse('', 401, array('WWW-Authenticate' => 'Basic realm="Phpbin Authorization Test"'));
        }

        // parse auth header
        $auth = explode(':', base64_decode(str_replace('Basic ', '', $request->headers->get('Authorization'))));

        // bad headers
        if (!is_array($auth) || count($auth) !== 2) {
            return new JsonResponse(array('authenticated' => false), 401);
        }

        // invalid values
        if ($auth[0] !== $request->get('user') || $auth[1] !== $request->get('passwd')) {
            return new JsonResponse(array('authenticated' => false), 401);
        }

        return new JsonResponse(array('authenticated' => true, 'user' => $request->get('user')), 200);
    }

    protected function getUnauthorizedResponse()
    {
        return new JsonResponse('', 401, array('WWW-Authenticate' => 'Basic realm="Phpbin Authorization Test"'));
    }
}