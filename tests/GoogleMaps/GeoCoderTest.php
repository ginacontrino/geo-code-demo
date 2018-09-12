<?php

namespace Tests\GoogleMaps;

use Gina\GoogleMaps\GeoCoder;
use Gina\GoogleMaps\HttpClient;
use Gina\GoogleMaps\ResponseParser;
use PHPUnit\Framework\TestCase;

final class GeoCoderTest extends TestCase
{

    /** @test */
    public function it_correctly_calls_google_maps_geocode_and_returns_parsed_response()
    {
        // Given an HTTP client...
        $client = $this->createMock(HttpClient::class);

        // ... which returns "['some_result']" when the following specific query is called
        $client->method('get')->willReturn(['some_result'])->with('https://maps.google.com/maps/api/geocode/json', [
            'key' => '1234',
            'language' => 'en',
            'sensor' => false,
            'address' => 'New York',
        ]);

        // AND Given a parser...
        $parser = $this->createMock(ResponseParser::class);

        // ... which returns ['parsed'] when called with "['some_result']"
        $parser->method('parse')->willReturn(['parsed'])->with(['some_result']);


        // AND a new instance of GeoCoder with the API key '1234'
        $geoCoder = new GeoCoder('1234', $parser, $client);


        // When we call the geoCoder with our query "New York"
        $result = $geoCoder->geoCode('New York');

        // Then the result should be ['parsed']
        $this->assertEquals(['parsed'], $result);
    }

}



