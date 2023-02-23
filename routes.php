<?php

use Core\Lib\Route;

return [
    'index' => Route::get('/', 'HomeController@index'),
    'param' => Route::get('/param/{string}', 'HomeController@param'),
    'test' => Route::get('/test', 'TestController@test'),
    'user' => Route::get('/user/{int}', 'TestController@user')
];