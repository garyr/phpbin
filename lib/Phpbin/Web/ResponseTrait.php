<?php

namespace Phpbin\Web;

use Symfony\Component\HttpFoundation\Request;

trait ResponseTrait
{
    protected function getBasicResponse(Request $request)
    {
        $args = $request->query->all();
        $response = array_merge(
            array('args' => $args),
            $this->getHeaders($request),
            $this->getOrigin($request),
            array('url' => $request->getUri())
        );
        ksort($response);
        return $response;
    }

    protected function getOrigin(Request $request)
    {
        if (!($address = $request->getClientIp())) {
            $address = '127.0.0.1';
        }
        return array('origin' => $address);
    }

    protected function getUserAgent(Request $request)
    {
        return array('user-agent' => $request->headers->get('user-agent'));
    }

    protected function getHeaders(Request $request)
    {
        $headers = $request->headers->all();
        foreach ($headers as $key => $value) {
            unset($headers[$key]);
            $fkey = implode('-', array_map('ucfirst', explode('-', $key)));
            $headers[$fkey] = implode(';', $value);
        }
        ksort($headers);
        return array('headers' => $headers);
    }
}