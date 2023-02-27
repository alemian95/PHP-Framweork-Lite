<?php

use Core\App;
use Core\Exceptions\RouteDoesNotExistsException;

function env($key)
{
    return getenv($key) ?? $_ENV[$key] ?? false;
}

function db() : \Doctrine\DBAL\Connection
{
    return App::$db;
}

function session() : \Symfony\Component\HttpFoundation\Session\Session
{
    return App::$session;
}

function request() : \Symfony\Component\HttpFoundation\Request
{
    return App::$request;
}

function route($name, ...$params)
{
    if (! isset(App::$routes[$name]))
    {
        throw new RouteDoesNotExistsException;
    }
    return App::$routes[$name]->url(...$params);
}

function mix($key)
{
    $file_content = file_get_contents(__DIR__ . '/../public/mix-manifest.json');
    $data = json_decode($file_content, true);
    return env('APP_URL') . $data[$key] ?? "";
}

function storagePath($path)
{
    return str_replace('public', 'storage', request()->server->get('DOCUMENT_ROOT')) . '/' . $path;
}

function asset($asset)
{
    return env('APP_URL') . "/public/" . $asset;
}