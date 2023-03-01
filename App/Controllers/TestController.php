<?php

namespace App\Controllers;

use App\Models\User;
use Core\Lib\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function test(Request $request)
    {
        dump(User::all());
    }

    public function user(Request $request, $user_id)
    {
        dump(csrf());

        $user = User::find($user_id);

        if (! $user)
        {
            http_response_code(404);
            die();
        }

        dump($user);
    }
}