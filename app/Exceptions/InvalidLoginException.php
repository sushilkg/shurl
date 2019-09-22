<?php

namespace App\Exceptions;

use Exception;

class InvalidLoginException extends Exception
{
    public function render($request)
    {
        return response('Invalid login credentials!', 400);
    }
}
