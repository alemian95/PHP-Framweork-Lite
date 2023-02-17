<?php

use Core\Lib\Route;

return [
    'index' => Route::get('/', 'HomeController@index'),
    'param' => Route::get('/param/{int}', 'HomeController@param'),
    'routes' => Route::get('/test', 'TestController@test')
];