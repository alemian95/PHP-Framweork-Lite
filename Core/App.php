<?php

namespace Core;

use Doctrine\DBAL\DriverManager;
use Error;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';


class App
{

    public static $db = null;

    public static $routes = [];

    public static Request $request;

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

        locale_set_default(getenv('APP_LOCALE'));
        date_default_timezone_set(getenv('APP_TIMEZONE'));


        static::$db = DriverManager::getConnection([
            'dbname' => getenv('DB_DATABASE'),
            'user' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'driver' => 'pdo_mysql',
            'charset' => 'utf8mb4'
        ]);


        static::$routes = include __DIR__ . "/../routes.php";

        static::$request = Request::createFromGlobals();

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

