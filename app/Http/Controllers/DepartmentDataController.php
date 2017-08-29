<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;
use DB;

use App\SchoolData;
use App\DepartmentData;

class DepartmentDataController extends Controller
{
    /** @var DepartmentData */
    private $DepartmentDataModel;

    /** @var SchoolData */
    private $SchoolDataModel;

    /**
     * DepartmentDataController constructor.
     *
     * @param DepartmentData $DepartmentDataModel
     * @param SchoolData $SchoolDataModel
     */
    public function __construct(DepartmentData $DepartmentDataModel, SchoolData $SchoolDataModel)
    {
        $this->DepartmentDataModel = $DepartmentDataModel;

        $this->SchoolDataModel = $SchoolDataModel;
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->admin != NULL) {
            return $this->DepartmentDataModel->all();
        }

        return $this->DepartmentDataModel->where('id', '=', $user->school_editor->school_code)->first();
    }

    public function show(Request $request, $school_id)
    {
        if ($this->SchoolDataModel->where('id', '=', $school_id)->exists()) {
            return $this->SchoolDataModel->where('id', '=', $school_id)->with('departments')->first();
        }

        $messages = array('School Data Not Found!');

        return response()->json(compact('messages'), 404);
    }
}
