<?php

namespace App\Middlewares;

use Core\Lib\Middleware;

class ExampleMiddleware extends Middleware
{

    public function resolve()
    {
        header('location: ' . route('user', 1));
    }
}