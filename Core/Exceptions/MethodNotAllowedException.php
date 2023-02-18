<?php

namespace Core\Exceptions;

use Exception;

class MethodNotAllowedException extends Exception
{
    protected $message = 'Method not allowed';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}