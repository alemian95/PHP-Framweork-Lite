<?php

namespace App\Controllers;

use Core\Lib\View;
use Symfony\Component\HttpFoundation\Request;

class HomeController
{

    public function index()
    {
        return View::make('home')
            ->title('Home')
            ->layout('layouts/app')
            ->with([ 'variable' => 'value' ])
            ->render();
    }

    public function param(Request $request, string $param)
    {
        echo 'param';
        dump($param);
        dump($request->get('var'));
        dump($request);
        dump(session());
    }
}