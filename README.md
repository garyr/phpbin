[![Build Status](https://secure.travis-ci.org/garyr/phpbin.png)](http://travis-ci.org/garyr/phpbin)

phpbin: HTTP Client Testing Service
=============

## Usage

    $ composer install

    # Start a web server on localhost:8000
    $ ./bin/console server:start

    Browse to

    http://localhost:8000/

## Curl Usage

    $ curl http://localhost:8000/get

Response
```javascript
{
    "args": {},
    "headers": {
        "Accept": "*/*",
        "Host": "localhost:8000",
        "User-Agent": "curl/7.30.0"
    },
    "origin": "127.0.0.1",
    "url": "http://localhost:8000/get"
}
```
