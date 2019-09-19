<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard');
    }
}
