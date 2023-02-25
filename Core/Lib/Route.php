<?php

namespace Core\Lib;

use Core\Exceptions\MethodNotAllowedException;
use Core\Exceptions\MissingParameterException;
use Symfony\Component\HttpFoundation\Request;

class Route
{

    const PARAM_INT_PLACEHOLDER = "{int}";
    const PARAM_INT_REGEX = "([0-9]+)";
    const PARAM_STRING_PLACEHOLDER = "{string}";
    const PARAM_STRING_REGEX = "([A-Za-z0-9-_%]+)";

    private static $allowed_methods = [ 'GET', 'POST', 'DELETE' ];

    private string $uri;
    private string $method;
    private array $middlewares;

    private string $controller;
    private string $callback;

    public function __construct($uri, $callback)
    {
        $this->uri = $uri;
        [ $this->controller, $this->callback ] = explode('@', $callback);
        $this->middlewares = [];
    }

    public static function get($uri, $callback) : self
    {
        return (new self($uri, $callback))->method('get');
    }

    public static function post($uri, $callback) : self
    {
        return (new self($uri, $callback))->method('post');
    }

    public static function delete($uri, $callback) : self
    {
        return (new self($uri, $callback))->method('delete');
    }

    public function method($method) : self
    {
        if (! in_array(strtoupper($method), self::$allowed_methods))
        {
            throw new MethodNotAllowedException;
        }
        $this->method = strtoupper($method);
        return $this;
    }

    public function middlewares($middlewares)
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function uri() : string
    {
        $uri = $this->uri;
        $uri = str_replace(static::PARAM_INT_PLACEHOLDER, static::PARAM_INT_REGEX, $uri);
        $uri = str_replace(static::PARAM_STRING_PLACEHOLDER, static::PARAM_STRING_REGEX, $uri);
        return "#^$uri(?:\?(.*))?$#";
    }

    public function url(...$params) : string
    {
        $uri = $this->uri;
        $uri = str_replace(static::PARAM_INT_PLACEHOLDER, '{param}', $uri);
        $uri = str_replace(static::PARAM_STRING_PLACEHOLDER, '{param}', $uri);

        foreach ($params as $param)
        {
            $placeholder = '{param}';
            $uri = preg_replace("/$placeholder/", $param, $uri, 1);
        }

        if (str_contains($uri, '{param}'))
        {
            throw new MissingParameterException;
        }

        return getenv('APP_URL') . $uri;
    }

    public function resolve($params, Request $request)
    {
        $this->resolveMiddlewares();
        $class = "App\\Controllers\\" . $this->controller;
        $instance = new $class();
        return $instance->{$this->callback}($request, ...$params);
    }

    private function resolveMiddlewares()
    {
        foreach ($this->middlewares as $middleware)
        {
            $class = "App\\Middlewares\\" . $middleware;
            $instance = new $class();
            $instance->resolve();
        }
    }

}