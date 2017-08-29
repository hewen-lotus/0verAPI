<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use DB;
use Auth;
use Validator;

use App\SchoolEditor;
use App\SystemHistoryData;
use App\SchoolHistoryData;
use App\DepartmentData;
use App\DepartmentHistoryData;
use App\DepartmentHistoryApplicationDocument;
use App\TwoYearTechDepartmentData;
use App\TwoYearTechHistoryDepartmentData;
use App\TwoYearTechDepartmentHistoryApplicationDocument;
use App\GraduateDepartmentData;
use App\GraduateDepartmentHistoryData;
use App\GraduateDepartmentHistoryApplicationDocument;

class ENGSystemHistoryDataController extends Controller
{
    /** @collect system_id_collection */
    private $system_id_collection;

    /** @collect department_quota_columns_collection */
    private $department_quota_columns_collection;

    /** @collect department_info_columns */
    private $department_info_columns;

    /** @collect departments_key_collection */
    private $departments_key_collection;

    /** @var SystemHistoryData */
    private $SystemHistoryDataModel;

    /** @var SchoolEditor */
    private $SchoolEditorModel;

    /** @var SchoolHistoryData */
    private $SchoolHistoryDataModel;

    /** @var TwoYearTechHistoryDepartmentData */
    private $TwoYearTechHistoryDepartmentDataModel;

    /** @var TwoYearTechDepartmentData */
    private $TwoYearTechDepartmentDataModel;

    /** @var DepartmentHistoryData */
    private $DepartmentHistoryDataModel;

    /** @var DepartmentData */
    private $DepartmentDataModel;

    /** @var GraduateDepartmentHistoryData */
    private $GraduateDepartmentHistoryDataModel;

    /** @var GraduateDepartmentData */
    private $GraduateDepartmentDataModel;

    /** @var DepartmentHistoryApplicationDocument */
    private $DepartmentHistoryApplicationDocumentModel;

    /** @var TwoYearTechDepartmentHistoryApplicationDocument */
    private $TwoYearTechDepartmentHistoryApplicationDocumentModel;

    /** @var GraduateDepartmentHistoryApplicationDocument */
    private $GraduateDepartmentHistoryApplicationDocumentModel;

    /**
     * SystemHistoryDataController constructor.
     *
     * @param SystemHistoryData $SystemHistoryDataModel
     * @param SchoolEditor $SchoolEditorModel
     * @param SchoolHistoryData $SchoolHistoryDataModel
     * @param TwoYearTechHistoryDepartmentData $TwoYearTechHistoryDepartmentDataModel
     * @param DepartmentHistoryData $DepartmentHistoryDataModel
     * @param GraduateDepartmentHistoryData $GraduateDepartmentHistoryDataModel
     * @param DepartmentHistoryApplicationDocument $DepartmentHistoryApplicationDocumentModel
     * @param TwoYearTechDepartmentHistoryApplicationDocument $TwoYearTechDepartmentHistoryApplicationDocumentModel
     * @param GraduateDepartmentHistoryApplicationDocument $GraduateDepartmentHistoryApplicationDocument
     * @param DepartmentData $DepartmentDataModel
     * @param TwoYearTechDepartmentData $TwoYearTechDepartmentDataModel
     * @param GraduateDepartmentData $GraduateDepartmentDataModel
     */
    public function __construct(SystemHistoryData $SystemHistoryDataModel,
                                SchoolEditor $SchoolEditorModel,
                                SchoolHistoryData $SchoolHistoryDataModel,
                                TwoYearTechHistoryDepartmentData $TwoYearTechHistoryDepartmentDataModel,
                                DepartmentHistoryData $DepartmentHistoryDataModel,
                                GraduateDepartmentHistoryData $GraduateDepartmentHistoryDataModel,
                                DepartmentHistoryApplicationDocument $DepartmentHistoryApplicationDocumentModel,
                                TwoYearTechDepartmentHistoryApplicationDocument $TwoYearTechDepartmentHistoryApplicationDocumentModel,
                                GraduateDepartmentHistoryApplicationDocument $GraduateDepartmentHistoryApplicationDocumentModel,
                                DepartmentData $DepartmentDataModel,
                                TwoYearTechDepartmentData $TwoYearTechDepartmentDataModel,
                                GraduateDepartmentData $GraduateDepartmentDataModel)
    {
        $this->middleware(['auth', 'switch']);

        $this->system_id_collection = collect([
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

        // 系所名額欄位，依學制分
        $this->department_quota_columns_collection = collect([
            1 => [
                'history_id',
                'id',
                'school_code',
                'sort_order',
                'title',
                'eng_title',
                'has_special_class',
                'has_self_enrollment',
                'admission_selection_quota',
                'last_year_admission_placement_quota', // 學士班才有
                'last_year_admission_placement_amount', // 學士班才有
                'admission_placement_quota', // 學士班才有
                'decrease_reason_of_admission_placement', // 學士班才有
                'created_at',
                'created_by',
            ],
            2 => [
                'history_id',
                'id',
                'school_code',
                'sort_order',
                'title',
                'eng_title',
                'has_special_class',
                'has_self_enrollment',
                'self_enrollment_quota',
                'admission_selection_quota',
                'created_at',
                'created_by',
            ],
            3 => [
                'history_id',
                'id',
                'school_code',
                'sort_order',
                'title',
                'eng_title',
                'has_special_class',
                'has_self_enrollment',
                'self_enrollment_quota',
                'admission_selection_quota',
                'created_at',
                'created_by',
            ],
            4 => [
                'history_id',
                'id',
                'school_code',
                'sort_order',
                'title',
                'eng_title',
                'has_special_class',
                'has_self_enrollment',
                'self_enrollment_quota',
                'admission_selection_quota',
                'created_at',
                'created_by',
            ]
        ]);

        // 系所資訊欄位
        $this->department_info_columns = [
                'history_id',
                'id',
                'school_code',
                'sort_order',
                'title',
                'eng_title',
                'has_special_class',
                'has_self_enrollment',
                'self_enrollment_quota',
                'admission_selection_quota',
                'created_at',
                'created_by',
        ];

        // 系所函式名反查
        $this->departments_key_collection = collect([
            1 => 'bachelor_departments',
            2 => 'two_year_tech_departments',
            3 => 'master_departments',
            4 => 'phd_departments'
        ]);

        $this->SystemHistoryDataModel = $SystemHistoryDataModel;

        $this->SchoolEditorModel = $SchoolEditorModel;

        $this->SchoolHistoryDataModel = $SchoolHistoryDataModel;

        $this->TwoYearTechHistoryDepartmentDataModel = $TwoYearTechHistoryDepartmentDataModel;

        $this->DepartmentHistoryDataModel = $DepartmentHistoryDataModel;

        $this->GraduateDepartmentHistoryDataModel = $GraduateDepartmentHistoryDataModel;

        $this->DepartmentHistoryApplicationDocumentModel = $DepartmentHistoryApplicationDocumentModel;

        $this->TwoYearTechDepartmentHistoryApplicationDocumentModel = $TwoYearTechDepartmentHistoryApplicationDocumentModel;

        $this->GraduateDepartmentHistoryApplicationDocumentModel = $GraduateDepartmentHistoryApplicationDocumentModel;

        $this->DepartmentDataModel = $DepartmentDataModel;

        $this->TwoYearTechDepartmentDataModel = $TwoYearTechDepartmentDataModel;

        $this->GraduateDepartmentDataModel = $GraduateDepartmentDataModel;
    }

    /**
     * @param Request $request
     * @param $school_id
     * @param $system_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $school_id, $system_id)
    {
        $user = Auth::user();

        // 接受 me 參數
        if ($user->school_editor != NULL) {
            if ($school_id == 'me') {
                $school_id = $user->school_editor->school_code;
            }
        }

        // mapping 學制 id（預設為 0）
        $system_id = $this->system_id_collection->get($system_id, 0);

        // 分辨要求為名額或資料
        $data_type = 'info';

        // 確認使用者權限
        if ($user->can('create_info', [SystemHistoryData::class, $school_id, $data_type])) {
            if ($system_id == 0) {
                $messages = ['System not found.'];

                return response()->json(compact('messages'), 404);
            }

            // 取得最新歷史版本
            $system_history_data = $this->SystemHistoryDataModel->select()
                ->where('school_code', '=', $school_id)
                ->where('type_id', '=', $system_id)
                ->latest()
                ->first();

            // 無歷史版本 => 無此學制歷史版本資料
            if ($system_history_data == NULL) {
                $messages = ['System history version not found.'];

                return response()->json(compact('messages'), 404);
            }

            // 設定資料驗證欄位
            $validation_rules = [
                'eng_description' => 'required|string' //學制英文敘述
            ];

            // 驗證輸入資料
            $validator = Validator::make($request->all(), $validation_rules);

            // 輸入資料驗證沒過
            if ($validator->fails()) {
                $messages = $validator->errors()->all();

                return response()->json(compact('messages'), 400);
            }

            // 整理輸入資料
            $insert_data = [
                'school_code' => $school_id,
                'type_id' => $system_id,
                'created_by' => $user->username,
                'ip_address' => $request->ip(),
                // 不可修改的資料承襲上次版本內容
                'quota_status' => $system_history_data->quota_status,
                'last_year_admission_amount' => $system_history_data->last_year_admission_amount,
                'ratify_expanded_quota' => $system_history_data->ratify_expanded_quota,
                'last_year_surplus_admission_quota' => $system_history_data->last_year_surplus_admission_quota,
                'ratify_quota_for_self_enrollment' => $system_history_data->ratify_quota_for_self_enrollment,
                'ratify_quota_for_admission' => $system_history_data->ratify_quota_for_admission,
                // 可修改的資料
                'description' => $system_history_data->description,
                'eng_description' => $request->input('eng_description')
            ];

            // 寫入資料
            $new_data = $this->SystemHistoryDataModel->create($insert_data);

            return $this->return_info($school_id, $system_id, $new_data->history_id, 201);
        } else {
            $messages = ['User don\'t have permission to access'];

            return response()->json(compact('messages'), 403);
        }
    }

    public function return_info($school_id, $system_id, $history_id = 'latest', $status_code = 200)
    {
        $user = Auth::user();

        // 依照要求拿取學制資料
        $data = $this->SystemHistoryDataModel->select()
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', $system_id)
            ->with('type', 'creator.school_editor');

        // 容許 latest 字眼（取最新一筆）
        if ($history_id == 'latest') {
            $data = $data->latest();
        } else {
            $data = $data->where('history_id', '=', $history_id);
        }

        $data = $data->first();

        // 沒有學制資訊？404 啦
        if ($data == NULL) {
            $messages = ['System Data Not Found!'];
            return response()->json(compact('messages'), 404);
        }

        // 取得使用者有權限的系所
        $permissionsDepartments = $this->SchoolEditorModel->select()
            ->where('username', '=', $user->username)
            ->with('department_permissions')
            ->first()
            ->department_permissions->map(function ($item) {
                return $item->dept_id;
            });

        // 依學制設定資料模型
        if ($system_id == 1) {
            $HistoryDataModel = $this->DepartmentHistoryDataModel;
            $DataModel = $this->DepartmentDataModel;
        } else if ($system_id == 2) {
            $HistoryDataModel = $this->TwoYearTechHistoryDepartmentDataModel;
            $DataModel = $this->TwoYearTechDepartmentDataModel;
        } else { // $system_id == 3 || $system_id == 4
            $HistoryDataModel = $this->GraduateDepartmentHistoryDataModel;
            $DataModel = $this->GraduateDepartmentDataModel;
        }

        // 取得系所列表
        if ($system_id == 3 || $system_id == 4) {
            // 碩博同表，需多加規則
            $departments_list = $DataModel->select('id')
                ->where('school_code', '=', $school_id)
                ->where('system_id', '=', $system_id)
                ->get();
        } else {
            // 學士二技各自有表
            $departments_list = $DataModel->select('id')
                ->where('school_code', '=', $school_id)
                ->get();
        }
        // 取得使用者有權限閱覽的系所資料
        $department_history_list = [];
        foreach ($departments_list as $dept) {
            $dept_history_data = $HistoryDataModel->select($this->department_info_columns)
                ->where('id', '=', $dept['id'])
                ->with('creator.school_editor')
                ->latest()
                ->first();

            // 編輯管理員有權看所有系所
            if ($user->school_editor->has_admin || $permissionsDepartments->has($dept['id'])) {
                array_push($department_history_list, $dept_history_data);
            }
        }

        $data->departments = $department_history_list;

        return response()->json($data, $status_code);
    }
}
