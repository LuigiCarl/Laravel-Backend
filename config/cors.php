<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'healthz'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        env('http://localhost:3000',
        'https://localhost:3000',
        'http://lms-laranext-1yg8.vercel.app/api',
        'https://lms-laranext-1yg8.vercel.app/api')
        // Add your deployed frontend URL here, e.g.:
        // 'https://your-frontend.vercel.app',
    ],

    // 'allowed_origins' => ['https://laravel-backend-production-6537.up.railway.app'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'Authorization', 'Accept'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
