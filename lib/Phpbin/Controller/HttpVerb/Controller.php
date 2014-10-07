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

    protected function handleData(Application $app, Request $request)
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

        $response = array_merge($response, array('files' => $files));
        $response = array_merge($response, array('form' => $form));
        ksort($response);

        return new JsonResponse($response, 200);
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
}