<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SyncHistoryDataToFormalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'switch']);
    }

    public function bachelor()
    {
        
    }

    public function two_year()
    {

    }

    public function master()
    {

    }

    public function phd()
    {

    }
}
