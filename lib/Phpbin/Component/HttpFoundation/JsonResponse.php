<?php

namespace Phpbin\Component\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;

class JsonResponse extends Response
{
    /**
     * Constructor.
     *
     * @param mixed   $content The response content, see setContent()
     * @param int     $status  The response status code
     * @param array   $headers An array of response headers
     *
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     *
     * @api
     */
    public function __construct($content = '', $status = 200, $headers = array())
    {
        $content = json_encode($content, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        return parent::__construct($content, $status, $headers);
    }
}
