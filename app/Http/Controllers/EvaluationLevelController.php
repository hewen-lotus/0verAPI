<?php

namespace App\Http\Controllers;

use App\EvaluationLevel;

class EvaluationLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'switch']);
    }

    public function index()
    {
        return EvaluationLevel::select('id', 'title', 'eng_title')->get();
    }
}
