<?php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // other global middleware here...
        \Illuminate\Http\Middleware\HandleCors::class,
    ];

    protected $middlewareGroups = [
        'api' => [
            // other API middleware here...
            \Illuminate\Http\Middleware\HandleCors::class,
        ],
    ];

    // other properties and methods...
}
