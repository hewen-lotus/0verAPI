<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainRouteController extends Controller
{
    public function index()
    {
        return view('welcome');
        // return config('schedule-of-applications.test');
    }
}
