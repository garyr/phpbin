<?php

namespace Phpbin\Controller\Cookies;

use Phpbin\Web\Application;
use Symfony\Component\HttpFoundation\Request;
use Phpbin\Component\HttpFoundation\JsonResponse;

class Controller
{
    public function executeIndex(Application $app, Request $request)
    {
        return new JsonResponse(array('cookies' => $request->cookies->all()), 200);
    }

    public function executeSet(Application $app, Request $request)
    {
        $expires = '';
        if ($request->query->has('expires')) {
            $expires = $request->query->get('expires');
            $request->query->remove('expires');
        }

        $cookies = $request->query->all();
        foreach ($cookies as $key => $value) {
            if (!empty($expires)) {
                $cookie = sprintf('%s=%s; Expires=%s', $key, $value, $expires);
            } else {
                $cookie = sprintf('%s=%s', $key, $value);
            }
            $headers['Set-Cookie'][] = $cookie;
        }

        // redirect to cookies list
        $headers['Location'] = '/cookies';
        return new JsonResponse('', 302, $headers);
    }

    public function executeDelete(Application $app, Request $request)
    {
        // delete cookie by setting its expired time in the past
        $cookies = $request->query->all();
        foreach ($cookies as $key => $value) {
            $cookie = sprintf('%s=%s; Expires=%s', $key, '', 'Thu, 01 Jan 1970 00:00:00 GMT');
            $headers['Set-Cookie'][] = $cookie;
        }

        // redirect to cookies list
        $headers['Location'] = '/cookies';
        return new JsonResponse('', 302, $headers);
    }
}