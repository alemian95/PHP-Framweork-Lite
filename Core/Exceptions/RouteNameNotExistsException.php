<?php

namespace Core\Exceptions;

use Exception;

class RouteNameNotExistsException extends Exception
{
    protected $message = 'Route name not exists';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}