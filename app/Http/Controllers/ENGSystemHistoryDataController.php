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
     * @param $history_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $school_id, $system_id, $history_id)
    {
        $user = Auth::user();

        // 接受 me 參數
        if ($user->school_editor != NULL) {
            if ($school_id == 'me') {
                $school_id = $user->school_editor->school_code;
            }
        }

        // mapping 學制 id
        $system_id = $this->system_id_collection->get($system_id, 0);

        if ($system_id == 0) {
            $messages = ['System id not found.'];

            return response()->json(compact('messages'), 404);
        }

        // 分辨要求為名額或資料
        $data_type = $request->query('data_type');

        // 確認使用者權限
        if ($user->can('view_info', [SystemHistoryData::class, $school_id, $data_type, $history_id])) {

            return $this->return_info($school_id, $system_id, $history_id);
        } else if ($user->can('view_quota', [SystemHistoryData::class, $school_id, $data_type, $history_id])) {

            return $this->return_quota($school_id, $system_id, $history_id);
        } else {
            $messages = ['User don\'t have permission to access'];
            
            return response()->json(compact('messages'), 403);
        }
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
        $data_type = $request->query('data_type');

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
                'description' => 'required|string', //學制敘述
                'eng_description' => 'present|string' //學制英文敘述
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
                'description' => $request->input('description'),
                'eng_description' => $request->input('eng_description')
            ];

            // 寫入資料
            $new_data = $this->SystemHistoryDataModel->create($insert_data);

            return $this->return_info($school_id, $system_id, $new_data->history_id, 201);
        } else if ($user->can('create_quota', [SystemHistoryData::class, $school_id, $data_type])) {
            $school_id = $user->school_editor->school_code;

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

            // 有 has_RiJian => 可個人申請可自招
            // 沒 has_RiJian，但有 has_special_class => 可個人申請不可自招
            // 沒 has_RiJian，也沒 has_special_class => 都不行

            // 驗證名額：
            // 若是碩博，則 可招生總量為 last_year_surplus_admission_quota + last_year_admission_amount + ratify_expanded_quota
            // 必須讓該學制所有系所的 admission_selection_quota + self_enrollment_quota <= 可招生總量

            // 若是學士，則 可招生總量為 last_year_surplus_admission_quota + last_year_admission_amount + ratify_expanded_quota
            // 必須讓 學士所有系所的 (admission_selection_quota + admission_placement_quota + self_enrollment_quota) + 二技所有系所的 (admission_selection_quota + self_enrollment_quota) <= 可招生總量

            // 若是二技，則 可招生總量為 學士班的 (last_year_surplus_admission_quota + last_year_admission_amount + ratify_expanded_quota)
            // 必須讓 學士所有系所的 (admission_selection_quota + admission_placement_quota + self_enrollment_quota) + 二技所有系所的 (admission_selection_quota + self_enrollment_quota) <= 可招生總量
            
            // 取得學校資料最新歷史版本
            $school_history_data = $this->SchoolHistoryDataModel->select()
                ->where('id', '=', $school_id)
                ->latest()
                ->first();

            // 依學制檢查名額量
            if ($system_id == 1) { // 學士學制名額驗證
                
                // 設定資料驗證欄位
                $validation_rules = [
                    'ratify_quota_for_self_enrollment' => 'required|integer|min:0', //學士班調查自招總量
                    'departments' => 'required|array',
                    'departments.*.id' => [
                        'required',
                        'string',
                        Rule::exists('department_data', 'id')->where(function ($query) use ($school_id) {
                            $query->where('school_code', $school_id);
                        })
                    ],
                    'departments.*.has_self_enrollment' => 'required|boolean',
                    'departments.*.admission_selection_quota' => 'required|integer|min:0',
                    'departments.*.admission_placement_quota' => 'required|integer|min:0',
                    'departments.*.decrease_reason_of_admission_placement' =>
                        'if_decrease_reason_required:id,admission_placement_quota,array',
                ];

                // 驗證輸入資料
                $validator = Validator::make($request->all(), $validation_rules);

                // 輸入資料驗證沒過
                if ($validator->fails()) {
                    $messages = $validator->errors()->all();

                    return response()->json(compact('messages'), 400);
                }
                
                // 可招生總量為 last_year_surplus_admission_quota + last_year_admission_amount + ratify_expanded_quota
                $total_can_Admissions = 
                    $system_history_data->last_year_surplus_admission_quota 
                    + $system_history_data->last_year_admission_amount 
                    + $system_history_data->ratify_expanded_quota;

                // 初始化欲招收總量
                $all_quota = 0;

                // 取得二技班每個系所的最新版歷史資料
                $two_years = DB::table('two_year_tech_department_history_data as depts')
                    ->join(DB::raw('(SELECT id, max(history_id) as newest FROM two_year_tech_department_history_data group by id) deptid'), function($join) use ($school_id) {
                        $join->on('depts.id', '=', 'deptid.id');
                        $join->on('depts.history_id', '=', 'newest');
                        $join->where('school_code','=', $school_id);
                    })->select('depts.*')->orderBy('sort_order', 'ASC')->get();

                // 累計二技班所有系所個人申請與自招量（校可自招且系有開自招才可加入計算）
                foreach ($two_years as $two_year) {
                    // 若數字為 NULL，則預設為 0
                    if ($two_year->self_enrollment_quota == null) {
                        $two_year->self_enrollment_quota = 0;
                    }

                    if ($two_year->admission_selection_quota == null) {
                        $two_year->admission_selection_quota = 0;
                    }

                    // 累計二技人數
                    if ($school_history_data->has_self_enrollment && $two_year->self_enrollment_quota) {
                        $all_quota += $two_year->admission_selection_quota + $two_year->self_enrollment_quota;
                    } else {
                        $all_quota += $two_year->admission_selection_quota;
                    }
                }

                // 累計要求的學士班個人申請、聯合分發人數
                foreach ($request->input('departments') as &$department_item) {
                    // 若數字為 NULL，則預設為 0
                    if ($department_item['admission_selection_quota'] == null) {
                        $department_item['admission_selection_quota'] = 0;
                    }
                    if ($department_item['admission_placement_quota'] == null) {
                        $department_item['admission_placement_quota'] = 0;
                    }

                    $all_quota += $department_item['admission_selection_quota'] + $department_item['admission_placement_quota'];
                }

                // 累計學士班自招總量
                if ($school_history_data->has_self_enrollment) {
                    $all_quota += $request->input('ratify_quota_for_self_enrollment', 0);
                }

                // 必須讓 學士所有系所的 (admission_selection_quota + admission_placement_quota) + 學士班自招總量 ratify_quota_for_self_enrollment + 二技所有系所的 (admission_selection_quota + self_enrollment_quota) <= 可招生總量
                if ($total_can_Admissions < $all_quota) {
                    $messages = ['各系所招生人數加總必須小於或等於可招生總量'];
                    
                    return response()->json(compact('messages'), 400);
                }
            } else if ($system_id == 2) { // 二技學制名額驗證
                
                // 設定資料驗證欄位
                $validation_rules = [
                    'departments' => 'required|array',
                    'departments.*.id' => [
                        'required',
                        'string',
                        Rule::exists('two_year_tech_department_data', 'id')->where(function ($query) use ($school_id) {
                            $query->where('school_code', $school_id);
                        })
                    ],
                    'departments.*.self_enrollment_quota' => 'required|integer|min:0',
                    'departments.*.admission_selection_quota' => 'required|integer|min:0'
                ];

                // 驗證輸入資料
                $validator = Validator::make($request->all(), $validation_rules);

                // 輸入資料驗證沒過
                if ($validator->fails()) {
                    $messages = $validator->errors()->all();

                    return response()->json(compact('messages'), 400);
                }

                // 二技可招生總量參照學士班資料
                $dept_system_history_data = $this->SystemHistoryDataModel->select()
                    ->where('school_code', '=', $school_id)
                    ->where('type_id', '=', 1)
                    ->latest()
                    ->first();

                $total_can_Admissions = $dept_system_history_data->last_year_surplus_admission_quota + $dept_system_history_data->last_year_admission_amount + $dept_system_history_data->ratify_expanded_quota;

                // 初始化欲招收總量
                $all_quota = 0;

                // 取得每個系所歷史資料的最新版
                $depts = DB::table('department_history_data as depts')
                    ->join(DB::raw('(SELECT id, max(history_id) as newest FROM department_history_data group by id) deptid'), function($join) use ($school_id) {
                        $join->on('depts.id', '=', 'deptid.id');
                        $join->on('depts.history_id', '=', 'newest');
                        $join->where('school_code','=', $school_id);
                    })->select('depts.*')->orderBy('sort_order', 'ASC')->get();

                // 累計要求的學士班個人申請、聯合分發人數
                foreach ($depts as $dept) {
                    $all_quota += $dept->admission_selection_quota + $dept->admission_placement_quota;
                }

                // 累計學士班自招總量
                if ($school_history_data->has_self_enrollment) {
                    $all_quota += $dept_system_history_data->ratify_quota_for_self_enrollment;
                }

                // 累計要求的二技班個人申請、聯合分發、自招量（校可自招且系有開自招才可加入計算）
                foreach ($request->input('departments') as &$department_item) {
                    // 取得每個系所的最新版資料
                    $two_year_dept_history_data = $this->TwoYearTechHistoryDepartmentDataModel->select()
                        ->where('id','=', $department_item['id'])
                        ->latest()
                        ->first();

                    if ($two_year_dept_history_data == NULL) {
                        $messages = ['Department history not found.'];

                        return response()->json(compact('messages'), 400);
                    }

                    // 若數字為 NULL，則預設為 0
                    if ($department_item['admission_selection_quota'] == null) {
                        $department_item['admission_selection_quota'] = 0;
                    }

                    if ($school_history_data->has_self_enrollment && $two_year_dept_history_data->has_self_enrollment) {
                        $all_quota += $department_item['admission_selection_quota'] + $department_item['self_enrollment_quota'];
                    } else {
                        $all_quota += $department_item['admission_selection_quota'];
                    }
                }

                // 必須讓 學士所有系所的 (admission_selection_quota + admission_placement_quota) + 學士班自招總量 ratify_quota_for_self_enrollment + 二技所有系所的 (admission_selection_quota + self_enrollment_quota) <= 可招生總量
                if ($total_can_Admissions < $all_quota) {
                    $messages = ['各系所招生人數加總必須小於或等於可招生總量'];
                    
                    return response()->json(compact('messages'), 400);
                }
            } else if ($system_id == 3 || $system_id == 4) {// 碩博學制名額驗證
                // 設定資料驗證欄位
                $validation_rules = [
                    'departments' => 'required|array',
                    'departments.*.id' => [
                        'required',
                        'string',
                        Rule::exists('graduate_department_data', 'id')->where(function ($query) use ($school_id) {
                            $query->where('school_code', $school_id);
                        })
                    ],
                    'departments.*.has_self_enrollment' => 'required|boolean',
                    'departments.*.self_enrollment_quota' => 'required_if:departments.*.has_self_enrollment,1|integer|min:0',
                    'departments.*.admission_selection_quota' => 'required|integer|min:0'
                ];

                // 驗證輸入資料
                $validator = Validator::make($request->all(), $validation_rules);

                // 輸入資料驗證沒過
                if ($validator->fails()) {
                    $messages = $validator->errors()->all();
                    
                    return response()->json(compact('messages'), 400);
                }

                // 可招生總量為 last_year_surplus_admission_quota + last_year_admission_amount + ratify_expanded_quota
                $total_can_Admissions = 
                    $system_history_data->last_year_surplus_admission_quota 
                    + $system_history_data->last_year_admission_amount 
                    + $system_history_data->ratify_expanded_quota;

                // 初始化欲招收總量
                $all_quota = 0;

                // 累計要求的碩博班個人申請、聯合分發、自招量（校可自招且系有開自招才可加入計算）
                foreach ($request->input('departments') as &$department_item) {
                    // 若是數字為 NULL，則預設為 0
                    if ($department_item['admission_selection_quota'] == NULL) {
                        $department_item['admission_selection_quota'] = 0;
                    }
                    if ($department_item['has_self_enrollment'] == NULL) {
                        $department_item['has_self_enrollment'] = 0;
                    }

                    if ($school_history_data->has_self_enrollment && $department_item['has_self_enrollment']) {
                        $all_quota += $department_item['admission_selection_quota'] + $department_item['self_enrollment_quota'];
                    } else {
                        $all_quota += $department_item['admission_selection_quota'];
                    }
                }

                // 必須讓該學制所有系所的 admission_selection_quota + self_enrollment_quota <= 可招生總量
                if ($total_can_Admissions < $all_quota) {
                    $messages = ['各系所招生人數加總必須小於或等於可招生總量'];
                    
                    return response()->json(compact('messages'), 400);
                }
            }

            // 整理輸入資料
            $insert_data = [
                'school_code' => $school_id,
                'type_id' => $system_id,
                'created_by' => $user->username,
                'ip_address' => $request->ip(),
                // 不可修改的資料承襲上次版本內容
                'description' => $system_history_data->description,
                'eng_description' => $system_history_data->eng_description,
                'last_year_admission_amount' => $system_history_data->last_year_admission_amount,
                'ratify_expanded_quota' => $system_history_data->ratify_expanded_quota,
            ];

            // 學士班特別資料整理
            if ($system_id == 1) {
                // 若校可自招，則寫入學士班自招總量
                if ($school_history_data->has_self_enrollment) {
                    $insert_data += [
                        'ratify_quota_for_self_enrollment' => $request->input('ratify_quota_for_self_enrollment')
                    ];
                }
            }

            // 二技班無 `last_year_surplus_admission_quota`（參照學士班）
            if ($system_id != 2) {
                $insert_data += [
                    'last_year_surplus_admission_quota' => $system_history_data->last_year_surplus_admission_quota
                ];
            }

            // 寫入學制資料
            $new_data = $this->SystemHistoryDataModel->create($insert_data);

            // 整理系所輸入資料
            foreach ($request->input('departments') as &$department) {
                // 依照學制不同，將每個系所資料寫入
                if ($system_id == 1) { // 學士班
                    // 取得最新版系所資料
                    $department_history_data = $this->DepartmentHistoryDataModel->select()
                        ->where('school_code', '=', $school_id)
                        ->where('id', '=', $department['id'])
                        ->latest()
                        ->first();

                    if ($department_history_data == NULL) {
                        $messages = ['Department history not found.'];

                        return response()->json(compact('messages'), 400);
                    }

                    // 整理系所寫入資料
                    $department_insert_data = [
                        'created_by' => $user->username,
                        'ip_address' => $request->ip(),
                        // 不可修改的資料承襲上次版本內容
                        'school_code' => $department_history_data->school_code,
                        'id' => $department_history_data->id,
                        'title' => $department_history_data->title,
                        'eng_title' => $department_history_data->eng_title,
                        'rank' => $department_history_data->rank,
                        'card_code' => $department_history_data->card_code,
                        'special_dept_type' => $department_history_data->special_dept_type,
                        'last_year_admission_placement_amount' => $department_history_data->last_year_admission_placement_amount,
                        'last_year_admission_placement_quota' => $department_history_data->last_year_admission_placement_quota,
                        'last_year_personal_apply_amount' => $department_history_data->last_year_personal_apply_amount,
                        'last_year_personal_apply_offer' => $department_history_data->last_year_personal_apply_offer,
                        'sort_order' => $department_history_data->sort_order,
                        'memo' => $department_history_data->memo,
                        'url' => $department_history_data->url,
                        'eng_url' => $department_history_data->eng_url,
                        'gender_limit' => $department_history_data->gender_limit,
                        'description' => $department_history_data->description,
                        'eng_description' => $department_history_data->eng_description,
                        'has_foreign_special_class' => $department_history_data->has_foreign_special_class,
                        'has_eng_taught' => $department_history_data->has_eng_taught,
                        'has_disabilities' => $department_history_data->has_disabilities,
                        'has_BuHweiHwaWen' => $department_history_data->has_BuHweiHwaWen,
                        'has_birth_limit' => $department_history_data->has_birth_limit,
                        'birth_limit_after' => $department_history_data->birth_limit_after,
                        'birth_limit_before' => $department_history_data->birth_limit_before,
                        'has_review_fee' => $department_history_data->has_review_fee,
                        'review_fee_detail' => $department_history_data->review_fee_detail,
                        'eng_review_fee_detail' => $department_history_data->has_birth_limit,
                        'main_group' => $department_history_data->main_group,
                        'sub_group' => $department_history_data->sub_group,
                        'group_code' => $department_history_data->group_code,
                        'evaluation' => $department_history_data->evaluation,
                        'has_special_class' => $department_history_data->has_special_class,
                        'admission_selection_quota' => $department['admission_selection_quota'],
                        'admission_placement_quota' => $department['admission_placement_quota']
                    ];

                    // 校有自招且系要自招才可自招，否則自招資訊重設
                    if ($school_history_data->has_self_enrollment && $department['has_self_enrollment']) {
                        $department_insert_data += [
                            'has_self_enrollment' => $department['has_self_enrollment']
                        ];
                    } else {
                        $department_insert_data += [
                            'has_self_enrollment' => false
                        ];
                    }

                    // 本年度分發名額需比去年分發的名額與實際錄取量都還小，就得填減招原因
                    if ($department['admission_placement_quota'] < $department_history_data->last_year_admission_placement_quota
                        && $department['admission_placement_quota'] < $department_history_data->last_year_admission_placement_amount
                    ) {
                        $department_insert_data += [
                            'decrease_reason_of_admission_placement' => $department['decrease_reason_of_admission_placement']
                        ];
                    }

                    // 寫入名額資訊
                    $new_department_data = $this->DepartmentHistoryDataModel->create($department_insert_data);
                } else if ($system_id == 2) { // 二技班
                    // 取得最新版系所資料
                    $department_history_data = $this->TwoYearTechHistoryDepartmentDataModel->select()
                        ->where('school_code', '=', $school_id)
                        ->where('id', '=', $department['id'])
                        ->latest()
                        ->first();

                    if ($department_history_data == NULL) {
                        $messages = ['Department history not found.'];

                        return response()->json(compact('messages'), 400);
                    }

                    // 整理系所寫入資料
                    $department_insert_data = [
                        'created_by' => $user->username,
                        'ip_address' => $request->ip(),
                        // 不可修改的資料承襲上次版本內容
                        'school_code' => $department_history_data->school_code,
                        'id' => $department_history_data->id,
                        'title' => $department_history_data->title,
                        'eng_title' => $department_history_data->eng_title,
                        'special_dept_type' => $department_history_data->special_dept_type,
                        'last_year_personal_apply_offer' => $department_history_data->last_year_personal_apply_offer,
                        'last_year_personal_apply_amount' => $department_history_data->last_year_personal_apply_amount,
                        'sort_order' => $department_history_data->sort_order,
                        'memo' => $department_history_data->memo,
                        'url' => $department_history_data->url,
                        'eng_url' => $department_history_data->eng_url,
                        'gender_limit' => $department_history_data->gender_limit,
                        'description' => $department_history_data->description,
                        'eng_description' => $department_history_data->eng_description,
                        'has_foreign_special_class' => $department_history_data->has_foreign_special_class,
                        'has_eng_taught' => $department_history_data->has_eng_taught,
                        'has_disabilities' => $department_history_data->has_disabilities,
                        'has_BuHweiHwaWen' => $department_history_data->has_BuHweiHwaWen,
                        'has_birth_limit' => $department_history_data->has_birth_limit,
                        'birth_limit_after' => $department_history_data->birth_limit_after,
                        'birth_limit_before' => $department_history_data->birth_limit_before,
                        'has_review_fee' => $department_history_data->has_review_fee,
                        'review_fee_detail' => $department_history_data->review_fee_detail,
                        'eng_review_fee_detail' => $department_history_data->eng_review_fee_detail,
                        'main_group' => $department_history_data->main_group,
                        'sub_group' => $department_history_data->sub_group,
                        'group_code' => $department_history_data->group_code,
                        'evaluation' => $department_history_data->evaluation,
                        'has_special_class' => $department_history_data->has_special_class,
                        'has_self_enrollment' => $department_history_data->has_self_enrollment,
                        'approve_no_of_special_class' => $department_history_data->approve_no_of_special_class,
                        'approval_doc_of_special_class' => $department_history_data->approval_doc_of_special_class,
                        'self_enrollment_quota' => $department_history_data->self_enrollment_quota,
                        'has_RiJian' => $department_history_data->has_RiJian,

                    ];

                    // 有 has_RiJian => 可個人申請可自招
                    // 沒 has_RiJian，但有 has_special_class => 可個人申請不可自招
                    // 沒 has_RiJian，也沒 has_special_class => 都不行

                    if ($department_history_data->has_RiJian) {
                        // 有日間二技部，可聯招
                        $department_insert_data += [
                            'admission_selection_quota' => $department['admission_selection_quota']
                        ];

                        // 有日間二技部，校有自招且系要自招才可自招，否則自招資訊照舊
                        if ($school_history_data->has_self_enrollment && $department_history_data->has_self_enrollment) {
                            $department_insert_data += [
                                'self_enrollment_quota' => $department['self_enrollment_quota']
                            ];
                        } else {
                            $department_insert_data += [
                                'self_enrollment_quota' => $department_history_data->self_enrollment_quota
                            ];
                        }
                    } else {
                        // 沒日間二技部，不可自招，自招資訊照舊
                        $department_insert_data += [
                            'self_enrollment_quota' => $department_history_data->self_enrollment_quota
                        ];

                        // 沒日間二技部，有開專班，可聯招
                        if ($department_history_data->has_special_class) {
                            $department_insert_data += [
                                'admission_selection_quota' => $department['admission_selection_quota'],
                            ];
                        } else {
                            $department_insert_data += [
                                'admission_selection_quota' => $department_history_data->admission_selection_quota,
                            ];
                        }
                    }

                    // 寫入名額資訊
                    $new_department_data = $this->TwoYearTechHistoryDepartmentDataModel->create($department_insert_data);
                } else { // $system_id == 3 || $system_id == 4 碩博學制
                    // 取得最新版系所資料
                    $department_history_data = $this->GraduateDepartmentHistoryDataModel->select()
                        ->where('school_code', '=', $school_id)
                        ->where('id', '=', $department['id'])
                        ->where('system_id', '=', $system_id)
                        ->latest()
                        ->first();

                    if ($department_history_data == NULL) {
                        $messages = ['department history not found.'];

                        return response()->json(compact('messages'), 400);
                    }

                    // 整理系所寫入資料
                    $department_insert_data = [
                        'created_by' => $user->username,
                        'ip_address' => $request->ip(),
                        // 不可修改的資料承襲上次版本內容
                        'school_code' => $department_history_data->school_code,
                        'id' => $department_history_data->id,
                        'title' => $department_history_data->title,
                        'eng_title' => $department_history_data->eng_title,
                        'special_dept_type' => $department_history_data->special_dept_type,
                        'last_year_personal_apply_offer' => $department_history_data->last_year_personal_apply_offer,
                        'last_year_personal_apply_amount' => $department_history_data->last_year_personal_apply_amount,
                        'sort_order' => $department_history_data->sort_order,
                        'memo' => $department_history_data->memo,
                        'url' => $department_history_data->url,
                        'eng_url' => $department_history_data->eng_url,
                        'gender_limit' => $department_history_data->gender_limit,
                        'description' => $department_history_data->description,
                        'eng_description' => $department_history_data->eng_description,
                        'has_foreign_special_class' => $department_history_data->has_foreign_special_class,
                        'has_eng_taught' => $department_history_data->has_eng_taught,
                        'has_disabilities' => $department_history_data->has_disabilities,
                        'has_BuHweiHwaWen' => $department_history_data->has_BuHweiHwaWen,
                        'has_birth_limit' => $department_history_data->has_birth_limit,
                        'birth_limit_after' => $department_history_data->birth_limit_after,
                        'birth_limit_before' => $department_history_data->birth_limit_before,
                        'has_review_fee' => $department_history_data->has_review_fee,
                        'review_fee_detail' => $department_history_data->review_fee_detail,
                        'eng_review_fee_detail' => $department_history_data->eng_review_fee_detail,
                        'main_group' => $department_history_data->main_group,
                        'sub_group' => $department_history_data->sub_group,
                        'group_code' => $department_history_data->group_code,
                        'evaluation' => $department_history_data->evaluation,
                        'has_special_class' => $department_history_data->has_special_class,
                        'system_id' => $system_id,
                        'admission_selection_quota' => $department['admission_selection_quota']
                    ];

                    // 校有自招且系要自招才可自招，否則自招資訊重設（自招人數照舊）
                    if ($school_history_data->has_self_enrollment && $department['has_self_enrollment']) {
                        $department_insert_data += [
                            'has_self_enrollment' => $department['has_self_enrollment'],
                            'self_enrollment_quota' => $department['self_enrollment_quota']
                        ];
                    } else {
                        $department_insert_data += [
                            'has_self_enrollment' => $department['has_self_enrollment'],
                            'self_enrollment_quota' => $department_history_data->self_enrollment_quota,
                        ];
                    }

                    // 寫入名額資料
                    $new_department_data = $this->GraduateDepartmentHistoryDataModel->create($department_insert_data);
                }

                // COPY 歷史版本的審查項目

                // 依學制設定審查項目資料模型
                if ($system_id == 1) { // 學士
                    $HistoryApplicationDocumentModel = $this->DepartmentHistoryApplicationDocumentModel;
                } else if ($system_id == 2) { // 二技
                    $HistoryApplicationDocumentModel = $this->TwoYearTechDepartmentHistoryApplicationDocumentModel;
                } else { // $system_id == 3 || $system_id == 4 碩博
                    $HistoryApplicationDocumentModel = $this->GraduateDepartmentHistoryApplicationDocumentModel;
                }

                // 取得上一版審查項目歷史版本
                $application_docs = $HistoryApplicationDocumentModel->where('history_id', '=', $department_history_data->history_id)->get();

                $docs_insert_data = [];

                // COPY 歷史版本的審查項目至最新版
                foreach ($application_docs as &$docs) {
                    $docs_insert_data[] = [
                        'history_id' => $new_department_data->history_id,
                        'dept_id' => $docs['dept_id'],
                        'type_id' => $docs['type_id'],
                        'description' => $docs['description'],
                        'eng_description' => $docs['eng_description'],
                        'required' => $docs['required'],
                        'modifiable' => $docs['modifiable'],
                    ];
                }

                $HistoryApplicationDocumentModel->create($docs_insert_data);
            }

            return $this->return_quota($school_id, $system_id, $new_data->history_id, 201);
        } else {
            $messages = ['User don\'t have permission to access'];
            
            return response()->json(compact('messages'), 403);
        }
    }

    public function return_quota($school_id, $system_id, $history_id = 'latest', $status_code = 200)
    {
        // 擷取資料，並依照學制
        $data = $this->SystemHistoryDataModel->select()
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', $system_id)
            ->with('type', 'creator.school_editor')
            ->latest()
            ->first();

        // 沒有學制資訊？404 啦
        if ($data == NULL) {
            $messages = ['System history data not found!'];

            return response()->json(compact('messages'), 404);
        }

        // 若為二技學制，則 last_year_surplus_admission_quota、last_year_admission_amount、ratify_expanded_quota 要從學士的資料拿
        if ($system_id == 2) {
            $another_system_data = $this->SystemHistoryDataModel->select()
                ->where('school_code', '=', $school_id)
                ->where('type_id', '=', 1)
                ->latest()
                ->first();

            $data->last_year_surplus_admission_quota = $another_system_data->last_year_surplus_admission_quota;
            $data->last_year_admission_amount = $another_system_data->last_year_admission_amount;
            $data->ratify_expanded_quota = $another_system_data->ratify_expanded_quota;
            // 需要學士班自招總量
            $data->ratify_quota_for_self_enrollment = $another_system_data->ratify_quota_for_self_enrollment;
        }

        // 依學制設定系所資料模型
        if ($system_id == 1) {
            $HistoryDataModel = $this->DepartmentHistoryDataModel;
            $DataModel = $this->DepartmentDataModel;

            $AnotherHistoryDataModel = $this->TwoYearTechHistoryDepartmentDataModel;
            $AnotherDataModel = $this->TwoYearTechDepartmentDataModel;
        } else if ($system_id == 2) {
            $HistoryDataModel = $this->TwoYearTechHistoryDepartmentDataModel;
            $DataModel = $this->TwoYearTechDepartmentDataModel;

            $AnotherHistoryDataModel = $this->DepartmentHistoryDataModel;
            $AnotherDataModel = $this->DepartmentDataModel;
        } else { // $system_id == 3 || $system_id == 4
            $HistoryDataModel = $this->GraduateDepartmentHistoryDataModel;
            $DataModel = $this->GraduateDepartmentDataModel;
        }

        // 從主表取得系所列表
        if ($system_id == 1 || $system_id == 2) {
            // 學士二技各自有表
            $departments_list = $DataModel->select('id')
                ->where('school_code', '=', $school_id)
                ->get();
            // 需取得另一個學制的系所列表
            $another_departments_list = $AnotherDataModel->select('id')
                ->where('school_code', '=', $school_id)
                ->get();
        } else if ($system_id == 3 || $system_id == 4) {
            // 碩博同表，需多加規則
            $departments_list = $DataModel->select('id')
                ->where('school_code', '=', $school_id)
                ->where('system_id', '=', $system_id)
                ->get();
        }

        // 取得使用者有權限閱覽的系所資料
        $department_quota_columns = $this->department_quota_columns_collection->get($system_id);

        $department_history_list = [];

        foreach ($departments_list as $dept) {
            $dept_history_data = $HistoryDataModel->select($department_quota_columns)
                ->where('id', '=', $dept['id'])
                ->with('creator.school_editor')
                ->latest()
                ->first();

            $department_history_list[] = $dept_history_data;
        }

        $data->departments = $department_history_list;

        // 若為學士或二技，要拿到另一個學制的自招額度總和跟個人申請總和
        if ($system_id == 1 || $system_id == 2) {
            $another_department_self_enrollment_quota = 0;
            $another_department_admission_selection_quota = 0;
            $another_department_admission_placement_quota = 0;

            if ($system_id == 1) {
                // 處理二技班名額
                foreach ($another_departments_list as $dept) {
                    $dept_history_data = $AnotherHistoryDataModel->select()
                        ->where('id', '=', $dept['id'])
                        ->with('creator.school_editor')
                        ->latest()
                        ->first();

                    // 累計二技有自招的自招名額
                    if ($dept_history_data->has_self_enrollment) {
                        $another_department_self_enrollment_quota += $dept_history_data->self_enrollment_quota;
                    }

                    // 累計個人申請名額
                    $another_department_admission_selection_quota += $dept_history_data->admission_selection_quota;
                }
            } else if ($system_id == 2) {
                // 學士班自招人數總量要從學制資訊拿
                $another_department_self_enrollment_quota = $another_system_data->ratify_quota_for_self_enrollment;

                // 處理學士班名額
                foreach ($another_departments_list as $dept) {
                    $dept_history_data = $AnotherHistoryDataModel->select()
                        ->where('id', '=', $dept['id'])
                        ->with('creator.school_editor')
                        ->latest()
                        ->first();

                    // 累計學士班分發總數
                    $another_department_admission_placement_quota += $dept_history_data->admission_placement_quota;

                    // 累計個人申請名額
                    $another_department_admission_selection_quota += $dept_history_data->admission_selection_quota;
                }

                // 設定學士班分發總數
                $data->another_department_admission_placement_quota = $another_department_admission_placement_quota;
            }

            // 兩學制都要有對方的自招人數、個人申請人數
            $data->another_department_self_enrollment_quota = $another_department_self_enrollment_quota;
            $data->another_department_admission_selection_quota = $another_department_admission_selection_quota;
        }

        // 兩學制都要拿到該校的 has_enrollment
        $school_history_data = $this->SchoolHistoryDataModel->select('has_self_enrollment')
            ->where('id', '=', $school_id)
            ->latest()
            ->first();

        $data->school_has_self_enrollment = $school_history_data->has_self_enrollment;

        return response()->json($data, $status_code);
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
