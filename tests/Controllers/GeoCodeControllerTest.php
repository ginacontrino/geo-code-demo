<?php

namespace Tests\Controllers;


use Gina\Controllers\CrappyRequest;
use Gina\Controllers\GeoCodeController;
use Gina\GoogleMaps\GeoCodeException;
use Gina\GoogleMaps\GeoCoder;
use PHPUnit\Framework\TestCase;

final class GeoCodeControllerTest extends TestCase
{

    /** @test */
    public function it_reads_query_from_request_and_calls_map_service_and_returns_response()
    {
        // given a request with the query "Seoul"
        $request = $this->createMock(CrappyRequest::class);
        $request->method('get')->with('query')->willReturn('Seoul');

        // and a geoCoder
        $geoCoder = $this->createMock(GeoCoder::class);
        $geoCoder->method('geoCode')->with('Seoul')->willReturn([
            'address' => 'Seoul, South Korea',
            'components' => ['A', 'B', 'C'],
        ]);

        // and our controller
        $controller = new GeoCodeController($geoCoder);


        // when the geocode action is called with that request
        $response = $controller->geoCode($request);

        // then it should return a valid response
        $this->assertEquals([
            'address' => 'Seoul, South Korea',
            'components' => ['A', 'B', 'C'],
        ], $response->getData());

        $this->assertEquals(false, $response->getErr());
    }

    /** @test */
    public function it_validates_the_request()
    {
        // given a request with NO query
        $request = $this->createMock(CrappyRequest::class);
        $request->method('get')->with('query')->willReturn(null);

        // and a geoCoder
        $geoCoder = $this->createMock(GeoCoder::class);

        // and our controller
        $controller = new GeoCodeController($geoCoder);

        // when the geocode action is called with that request
        $response = $controller->geoCode($request);

        // then it should return a valid response
        $this->assertEquals('MissingQuery', $response->getData());

        $this->assertEquals(true, $response->getErr());
    }

    /** @test */
    public function it_handles_geo_coding_errors()
    {
        // given a request with the query "Seoul"
        $request = $this->createMock(CrappyRequest::class);
        $request->method('get')->with('query')->willReturn('Seoul');

        // and a geoCoder
        $geoCoder = $this->createMock(GeoCoder::class);
        $geoCoder->method('geoCode')->with('Seoul')->willThrowException(new GeoCodeException('NoGood'));

        // and our controller
        $controller = new GeoCodeController($geoCoder);


        // when the geocode action is called with that request
        $response = $controller->geoCode($request);

        // then it should return a valid response
        $this->assertEquals('NoGood', $response->getData());

        $this->assertEquals(true, $response->getErr());
    }
}



