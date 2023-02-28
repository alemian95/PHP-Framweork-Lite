<?php

namespace App\Middlewares;

use Core\Lib\Middleware;

class ExampleMiddleware extends Middleware
{

    public function resolve()
    {
        return redirect(route('user', 1));
    }
}