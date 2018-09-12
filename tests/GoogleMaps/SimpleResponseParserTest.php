<?php

namespace Tests\GoogleMaps;


use Gina\GoogleMaps\GeoCodeException;
use Gina\GoogleMaps\SimpleResponseParser;
use PHPUnit\Framework\TestCase;

final class SimpleResponseParserTest extends TestCase
{

    /** @test */
    public function it_correctly_parses_a_valid_and_successful_google_api_response_string()
    {
        // given a valid google api response json
        $result = '{
          "status": "OK",
          "results": [
            {
              "address_components": [
                {"long_name": "A"},
                {"long_name": "B"},
                {"long_name": "C"}
              ],
              "formatted_address": "Nice address, much parsed"
            }
          ]
        }';

        // when we parse it
        $parsed = (new SimpleResponseParser())->parse($result);

        // then we should get the correct result
        $this->assertEquals([
            'address' => 'Nice address, much parsed',
            'components' => ['A', 'B', 'C'],
        ], $parsed);
    }


    /** @test */
    public function it_disallows_invalid_json_strings()
    {
        // given a valid google api response json
        $result = 'whoop!';

        // we should get an exception when we try to parse it
        $this->expectException(GeoCodeException::class);

        (new SimpleResponseParser())->parse($result);
    }


    /** @test */
    public function it_throws_exception_if_unexpected_json_format_case_1()
    {
        // given a google api response json without "response" key
        $result = '{
          "status": "OK"
        }';

        // we should get an exception when we try to parse it
        $this->expectException(GeoCodeException::class);

        (new SimpleResponseParser())->parse($result);
    }

    /** @test */
    public function it_throws_exception_if_unexpected_json_format_case_2()
    {
        // given a google api response json without "status" key
        $result = '{
          "results": [
            {
              "address_components": [
                {"long_name": "A"},
                {"long_name": "B"},
                {"long_name": "C"}
              ],
              "formatted_address": "Nice address, much parsed"
            }
          ]
        }';

        // we should get an exception when we try to parse it
        $this->expectException(GeoCodeException::class);

        (new SimpleResponseParser())->parse($result);
    }

    /** @test */
    public function it_throws_exception_if_not_OK_status_code()
    {
        // given a valid google api response json with non OK status
        $result = '{
          "status": "Not Perfect",
          "results": [
            {
              "address_components": [
                {"long_name": "A"},
                {"long_name": "B"},
                {"long_name": "C"}
              ],
              "formatted_address": "Nice address, much parsed"
            }
          ]
        }';

        // we should get an exception when we  try parse it
        $this->expectException(GeoCodeException::class);

        (new SimpleResponseParser())->parse($result);
    }

    /** @test */
    public function it_handles_empty_results()
    {
        // given a valid google api response json with non OK status
        $result = '{
          "status": "ZERO_RESULTS",
          "results": []
        }';

        $parsed = (new SimpleResponseParser())->parse($result);

        // then we should get null as our result result
        $this->assertEquals(null, $parsed);

    }

    /** @test */
    public function it_disallows_empty_results_even_when_status_OK()
    {
        // given a valid google api response json with non OK status
        $result = '{
          "status": "OK",
          "results": []
        }';

        // we should get an exception when we try to parse it
        $this->expectException(GeoCodeException::class);

        (new SimpleResponseParser())->parse($result);
    }

    // todo: more checking but I got bored.

}



