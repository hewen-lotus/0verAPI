<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use DB;
use Auth;
use Validator;

//use App\SchoolEditor;
//use App\SchoolHistoryData;
use App\SystemHistoryData;
use App\DepartmentData;
use App\DepartmentHistoryData;
use App\TwoYearTechDepartmentData;
use App\TwoYearTechHistoryDepartmentData;
use App\GraduateDepartmentData;
use App\GraduateDepartmentHistoryData;



class DepartmentHistoryDataController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'switch']);

        $this->systemIdCollection = collect([
            'bachelor' => 1,
            1 => 1,
            'two-year' => 2,
            'twoYear' => 2,
            2 => 2,
            'master' => 3,
            3 => 3,
            'phd' => 4,
            4 => 4,
        ]);
    }

    public function show($school_id, $system_id, $department_id, $histories_id)
    {
        $user = Auth::user();

        // 接受 me 參數
        if ($user->school_editor != NULL) {
            if ($school_id == 'me') {
                $school_id = $user->school_editor->school_code;
            }
        }

        // mapping 學制 id
        $system_id = $this->systemIdCollection->get($system_id, 0);

        // 驗證學制是否存在
        if ($system_id == 0) {
            $messages = array('System  not found.');
            return response()->json(compact('messages'), 404);
        }

        if ($user->can('view', [DepartmentHistoryData::class, $school_id, $system_id, $department_id, $histories_id])) {

            // 依照要求拿取系所資料
            return $this->getDataById($department_id);
        }
    }

    public function getDataById($id, $status_code = 200)
    {
        $data = DepartmentHistoryData::where('id', '=', $id)
            ->with('creator.school_editor', 'reviewer.admin')
            ->latest()
            ->first();

        // TODO 缺 `application_docs` 欄位（需是一個 ApplicationDocument array）

        if ($data->info_status == 'editing' || $data->info_status == 'returned') {
            $lastReturnedData = DepartmentHistoryData::where('id', '=', $id)
                ->where('info_status', '=', 'returned')
                ->with('creator.school_editor', 'reviewer.admin')
                ->latest()
                ->first();
        } else {
            $lastReturnedData = NULL;
        }

        $data->last_returned_data = $lastReturnedData;

        return response()->json($data, $status_code);
    }
}
