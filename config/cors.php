<?php

// return [

//     /*
//     |--------------------------------------------------------------------------
//     | Cross-Origin Resource Sharing (CORS) Configuration
//     |--------------------------------------------------------------------------
//     |
//     | Here you may configure your settings for cross-origin resource sharing
//     | or "CORS". This determines what cross-origin operations may execute
//     | in web browsers. You are free to adjust these settings as needed.
//     |
//     | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
//     |
//     */

//     'paths' => ['*'],

//     'allowed_methods' => ['*'],

//     'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],

//     'allowed_origins_patterns' => [],

//     'allowed_headers' => ['*'],

//     'exposed_headers' => [],

//     'max_age' => 0,

//     'supports_credentials' => true,

// ];

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', '*'], // Add your paths here
    'allowed_methods' => ['*'], // Allow all methods
    'allowed_origins' => ['http://localhost:3000'], // Your frontend origin
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Set to true if you're using cookies
];
