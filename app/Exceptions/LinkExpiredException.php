<?php

namespace App\Exceptions;

use Exception;

class LinkExpiredException extends Exception
{
    public function render($request)
    {
        return response('Link expired!', 410);
    }
}
