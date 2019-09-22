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
        $link->delete();
    }

    public function search(Request $request)
    {
        $links = Link::withTrashed();

        if (!empty($request->short_tag)) {
            $links->where('short_tag', 'like', '%'.$request->short_tag.'%');
        }

        if (!empty($request->long_url)) {
            $links->where('long_url', 'like', '%'.$request->long_url.'%');
        }

        return $links->get();
    }
}
