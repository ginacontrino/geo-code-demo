<?php

namespace Gina\Controllers;

use Gina\GoogleMaps\GeoCodeException;
use Gina\GoogleMaps\GeoCoder;

class GeoCodeController
{
    private $geoCoder;

    public function __construct(GeoCoder $geoCoder)
    {
        $this->geoCoder = $geoCoder;
    }

    public function geoCode(CrappyRequest $request): CrappyResponse
    {
        $query = $request->get('query', null);
        if (trim($query) === '') {
            return CrappyResponse::unexpectedError('MissingQuery');
        }

        try {
            $result = $this->geoCoder->geoCode((string) $query);
        } catch (GeoCodeException $e) {
            return CrappyResponse::unexpectedError($e->getMessage());
        }

        return CrappyResponse::json($result, true);
    }
}
