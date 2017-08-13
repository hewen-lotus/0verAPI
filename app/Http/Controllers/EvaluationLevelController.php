<?php

namespace App\Http\Controllers;

use App\EvaluationLevel;

class EvaluationLevelController extends Controller
{
    /** @var EvaluationLevel */
    private $EvaluationLevelModel;

    /**
     * EvaluationLevelController constructor.
     *
     * @param EvaluationLevel $EvaluationLevelModel
     */
    public function __construct(EvaluationLevel $EvaluationLevelModel)
    {
        $this->middleware(['auth', 'switch']);

        $this->EvaluationLevelModel = $EvaluationLevelModel;
    }

    public function index()
    {
        return $this->EvaluationLevelModel->select('id', 'title', 'eng_title')->get();
    }
}
