<?php

namespace Phpbin\Controller\Status;

use Phpbin\Web\Application;
use Phpbin\Web\ResponseTrait;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
    use ResponseTrait;

    public function executeIndex(Application $app, Request $request)
    {
        $code = $request->get('code');
        $headers = array();
        $params = $request->query->all();
        foreach ($params as $key => $value) {
            $fkey = implode('-', array_map('ucfirst', explode('-', $key)));
            $headers[$fkey] = $value;
        }

        return $this->handleData($app, $request, $code, $headers);
    }
}
