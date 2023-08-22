<?php

return [
    'algo'   => env('JWT_AUTH_ALGO', 'HS256'),
    'secret' => env('JWT_AUTH_SECRET', null), # secret should be set up
    'ttl'    => env('JWT_AUTH_TTL', 3600 * 24 * 30), #One hour
];