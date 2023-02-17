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

    public function param(Request $request, int $param)
    {
        echo 'param';
        dump($param);
        dump($request);
    }
}