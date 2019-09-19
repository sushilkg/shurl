<?php

namespace App\Exceptions;

use Exception;

class LinkGoneException extends Exception
{
    public function render($request)
    {
        return response($request, 410);
    }
}
