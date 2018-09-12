<?php

namespace Gina\Controllers;

use Gina\GoogleMaps\HttpClient;

class CrappyRequest implements HttpClient
{
    public function get($key, $fallback)
    {
        return array_key_exists($key, $_GET) ? $_GET[$key] : $fallback;
    }
}
