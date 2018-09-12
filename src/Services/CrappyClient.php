<?php

namespace Gina\Services;

use Gina\GoogleMaps\HttpClient;

class CrappyClient implements HttpClient
{
    public function get($url, $params)
    {
        return file_get_contents($url . '?' . http_build_query($params));
    }
}
