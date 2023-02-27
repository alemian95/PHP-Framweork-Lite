<?php

namespace App\Controllers;

use Core\Lib\Controller;
use Core\Lib\View;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
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