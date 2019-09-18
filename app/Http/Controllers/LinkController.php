<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function store()
    {
        Link::create(request(['long_url', 'short_tag', 'expiration_date', 'hits']));
    }
}
