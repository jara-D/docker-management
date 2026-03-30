<?php


use Illuminate\Http\Request;

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | Trust Traefik (or any reverse proxy) by using "*".
    |
    */

    'proxies' => '*',

    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    |
    | Tell Laravel how to interpret forwarded HTTPS headers.
    |
    */

    'headers' => Request::HEADER_X_FORWARDED_AWS_ELB,
];
