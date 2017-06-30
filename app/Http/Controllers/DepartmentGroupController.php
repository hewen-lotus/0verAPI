<?php

namespace App\Http\Controllers;

use App\DepartmentGroup;

class DepartmentGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'switch']);
    }

    public function index()
    {
        return DepartmentGroup::select('id', 'title', 'eng_title')->get();
    }
}
