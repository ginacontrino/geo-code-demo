<?php

namespace Gina\GoogleMaps;

class GeoCoder
{
    private $key;
    private $parser;
    private $client;

    public function __construct(string $key, ResponseParser $parser, HttpClient $client)
    {
        $this->key = $key;
        $this->parser = $parser;
        $this->client = $client;
    }


    public function geoCode(string $query) : ?array
    {
        $result = $this->client->get('https://maps.google.com/maps/api/geocode/json', [
            'key' => $this->key,
            'language' => 'en',
            'sensor' => false,
            'address' => $query,
        ]);

        return $this->parser->parse($result);
    }
}
