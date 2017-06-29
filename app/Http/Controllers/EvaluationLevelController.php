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

    public function show()
    {
        $messages = ['Method Not Allowed.'];

        return response()->json(compact('messages'), 405);
    }

    public function store()
    {
        $messages = ['Method Not Allowed.'];

        return response()->json(compact('messages'), 405);
    }

    public function destroy()
    {
        $messages = ['Method Not Allowed.'];

        return response()->json(compact('messages'), 405);
    }
}
