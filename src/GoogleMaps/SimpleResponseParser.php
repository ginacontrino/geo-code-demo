<?php

namespace Gina\GoogleMaps;

class SimpleResponseParser implements ResponseParser
{
    public function parse($jsonString)
    {
        $data = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new GeoCodeException('InvalidJson');
        }

        $status = $data['status'] ?? null;
        if ($status === 'ZERO_RESULTS') {
            return null;
        }

        if ($status !== 'OK') {
            throw new GeoCodeException('BadStatus');
        }

        $results = $data['results'] ?? null;
        if ($results === null) {
            throw new GeoCodeException('MissingResults');
        }

        if (count($results) === 0) {
            throw new GeoCodeException('UnexpectedEmptyResults');
        }

        $response = ['components' => []];


        foreach ($results[0]['address_components'] as $component) {
            $response['components'][] = $component['long_name'];
        }
        $response['address'] = $data['results'][0]['formatted_address'];

        return $response;
    }
}

