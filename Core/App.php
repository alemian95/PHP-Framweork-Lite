<?php

namespace Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

require_once __DIR__ . '/functions.php';


class App
{

    public static ?Connection $db = null;

    public static $routes = [];

    public static Request $request;
    public static Session $session;

    public static function boot()
    {

        if (ENVIRONMENT === 'production')
        {
            (new Dotenv())->load(__DIR__ . '/../.env');
        }

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        ini_set('html_errors', 1);
        error_reporting(E_ALL);

        locale_set_default(env('APP_LOCALE'));
        date_default_timezone_set(env('APP_TIMEZONE'));


        static::$db = DriverManager::getConnection([
            'dbname' => env('MYSQL_DATABASE'),
            'user' => env('MYSQL_USER'),
            'password' => env('MYSQL_PASSWORD'),
            'host' => env('MYSQL_HOST'),
            'port' => env('MYSQL_PORT'),
            'driver' => 'pdo_mysql',
            'charset' => env('MYSQL_CHARSET'),
        ]);


        static::$routes = include __DIR__ . "/../routes.php";

        static::$request = Request::createFromGlobals();
        static::$session = new Session();
        static::$session->start();

        $requestUri = static::$request->getRequestUri();
        $method = static::$request->getMethod();

        foreach (static::$routes as $route)
        {
            if (preg_match($route->uri(), $requestUri, $matches))
            {

                if ($route->getMethod() !== $method)
                {
                    http_response_code(405);
                    die();
                }

                array_shift($matches);
                return $route->resolve($matches, static::$request);
            }
        }

        http_response_code(404);
        die();

    }
}

