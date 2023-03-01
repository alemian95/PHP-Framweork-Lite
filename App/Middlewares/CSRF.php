<?php

namespace App\Middlewares;

use Core\Lib\Middleware;

class CSRF extends Middleware
{

    public function resolve()
    {
        if (request()->get('csrf') !== session()->get('csrf'))
        {
            http_response_code(401);
            die();
        }
    }
}