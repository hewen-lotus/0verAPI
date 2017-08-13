<?php

namespace App\Http\Controllers;

use App\DepartmentGroup;

class DepartmentGroupController extends Controller
{
    /** @var DepartmentGroup */
    private $DepartmentGroupModel;

    /**
     * DepartmentGroupController constructor.
     *
     * @param DepartmentGroup $DepartmentGroupModel
     */
    public function __construct(DepartmentGroup $DepartmentGroupModel)
    {
        $this->middleware(['auth', 'switch']);

        $this->DepartmentGroupModel = $DepartmentGroupModel;
    }

    public function index()
    {
        return $this->DepartmentGroupModel->select('id', 'title', 'eng_title')->get();
    }
}
