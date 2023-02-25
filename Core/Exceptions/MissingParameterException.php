<?php

namespace Core\Exceptions;

use Exception;

class MissingParameterException extends Exception
{
    protected $message = 'Missing parameter';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}