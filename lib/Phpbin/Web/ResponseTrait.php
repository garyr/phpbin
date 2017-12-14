<?php

namespace Phpbin\Web;

use Symfony\Component\HttpFoundation\Request;
use Phpbin\Component\HttpFoundation\JsonResponse;

trait ResponseTrait
{
    protected function handleData(Application $app, Request $request, $response_code = 200, $headers = [])
    {
        // get basic response objec
        $response = $this->getBasicResponse($request);

        // get upload files (if any)
        $files = $request->files->all();

        // handle file uploads
        foreach ($files as $key => $UploadedFile) {
            $file = $UploadedFile->openFile('r');

            $bytes = '';
            while (!$file->eof()) {
                $bytes .= $file->current();
                $file->next();
            }

            // look for binary data
            if ($this->isBinary($bytes)) {
                $bytes = base64_encode($bytes);
            }

            $files[$key] = $bytes;
        }

        // form data
        $form = $request->request->all();
        if (count($form) > 0) {
            $keys = array_keys($form);
            // look for binary data
            if ($this->isBinary($form[$keys[0]])) {
                $bytes = '';
                foreach ($form as $value) {
                    if (is_string($value)) {
                        $bytes .= strval($value);
                    }
                }
                $bytes = base64_encode($bytes);
                $form = $bytes;
            }
        }

        // json data
        if ($json = json_decode($request->getContent(), true)) {
            $response = array_merge($response, array('json' => $json));
        }

        $response = array_merge($response, array('files' => $files));
        $response = array_merge($response, array('form' => $form));
        ksort($response);

        return new JsonResponse($response, $response_code, $headers);
    }

    protected function isBinary($string)
    {
        $byte_array = unpack('C*', $string);
        // Only ascii 32 thru 126 (inclusive) are considered printable. Tab (ascii 7), carriage return (ascii 13), linefeed (ascii 10)
        foreach ($byte_array as $value) {
            if ($value == 7 || $value == 13 || $value == 10) {
                continue;
            }
            if ($value < 32 || $value > 126) {
                return true; // binary character
            }
        }
        return false;
    }

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
