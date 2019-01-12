## Geo Code Demo

### Getting started

No depencies required, simply start the server with: 

`KEY=your_google_api_key php -S localhost:8000` (or any other port)

### Test
- Install dependencies via `composer install` (I am using PHPUnit)
- Run tests via `./vendor/bin/phpunit --colors --bootstrap vendor/autoload.php tests/`

### Start making requests
Use the following API to make a location request via the command line:

`curl -s "http://localhost:8000/?query=potsdamer%20platz" | python -m json.tool`

In this case I used "Potsdamer Platz" as an example for the query.

### The response you are getting back

Given the example "Potsdamer Platz", the response would look like this:
```
{
     "data": {
         "address": "Potsdamer Platz, 10785 Berlin, Germany",
         "components": [
             "Potsdamer Platz",
             "Mitte",
             "Berlin",
             "Berlin",
             "Germany",
             "10785"
         ]
     },
     "ok": true
}
```

### Class Overview

*GoogleMaps:*
- `Gina\GoogleMaps\GeoCode`: makes http requests to Google and parses response
- `Gina\GoogleMaps\ResponseParser`: interface for parsing the Google api response 
- `Gina\GoogleMaps\SimpleResponseParser`: minimal implementation of above interface
- `Gina\GoogleMaps\HttpClient`: interface expecting a single "GET" method
- `Gina\GoogleMaps\GeoCodeException`: domain exception thrown by the geocoder

*Controllers:*
- `Gina\Controllers\CrappyRequest`: minimal crappy request reader class
- `Gina\Controllers\CrappyResponse`: minimal crappy response builder class
- `Gina\Controllers\GeoCodeController`: takes a request, delegates to geocoder, returns response

*index.php*
-  reads API key from env `// todo: proper .env file`
- instantiates the geocoder `// todo: proper service container`
- creates request from globals `// todo: proper request builder`
- passes request to controller `// todo: proper router`
- writes response `// todo: proper response writer`

*Tests*
Unit tests for the modules above. `// todo: integration tests`
 
