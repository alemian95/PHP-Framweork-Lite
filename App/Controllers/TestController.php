<?php

namespace App\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class TestController
{

    public function test(Request $request)
    {
        echo 'test';
    }
}