<?php

namespace App\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class TestController
{

    public function test(Request $request)
    {
        dump(User::all());
    }

    public function user(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if (! $user)
        {
            http_response_code(404);
            die();
        }

        dump($user);
    }
}