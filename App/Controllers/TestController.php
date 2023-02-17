<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

class TestController
{

    public function test(Request $request)
    {
        echo 'test';

        dump($request);
    }
}