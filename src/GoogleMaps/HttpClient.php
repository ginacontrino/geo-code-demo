<?php

namespace Gina\GoogleMaps;

interface HttpClient
{
    public function get($url, $params);
}
