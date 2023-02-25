<?php

namespace Core\Exceptions;

use Exception;

class RouteDoesNotExistsException extends Exception
{
    protected $message = 'Route does not exists';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}