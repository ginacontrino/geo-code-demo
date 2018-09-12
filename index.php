<?php

use Gina\Controllers\CrappyRequest;
use Gina\Controllers\CrappyResponse;
use Gina\Controllers\GeoCodeController;
use Gina\GoogleMaps\GeoCoder;
use Gina\GoogleMaps\SimpleResponseParser;
use Gina\Services\CrappyClient;

require __DIR__ . '/vendor/autoload.php';

// read the api key from the environment variable
$apiKey = getenv('KEY');
if ($apiKey === null || strlen($apiKey) === 0) {
    return CrappyResponse::unexpectedError('NoApiKey')->execute();
}

// Create a new instance of the geo-coder
$geoCoder = new GeoCoder($apiKey, new SimpleResponseParser(), new CrappyClient());

// pass the request and get a response
$response = (new GeoCodeController($geoCoder))->geoCode($request = new CrappyRequest());

// execute the response
$response->execute();
