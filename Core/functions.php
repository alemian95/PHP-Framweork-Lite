<?php

use Core\App;

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