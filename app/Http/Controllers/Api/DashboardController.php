<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function all()
    {
        return Link::all();
    }

    public function view(Link $link)
    {
        return $link;
    }

    public function delete(Link $link)
    {
        return $link->delete();
    }

    public function search(Request $request)
    {
        return Link::where(['short_tag' => $request->short_tag])
            ->orWhere(['long_url' => $request->long_url])
            ->find();
    }
}
