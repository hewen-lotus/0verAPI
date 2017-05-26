<?php

namespace App\Http\Controllers;

use App\SchoolHistoryData;
use App\TwoYearTechHistoryDepartmentData;
use App\GraduateDepartmentHistoryData;
use Illuminate\Http\Request;

use Auth;
use Validator;
use Illuminate\Validation\Rule;

use App\SystemHistoryData;
use App\DepartmentHistoryData;

class SystemHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->isLockedCollection = collect(['waiting', 'confirmed']);

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

        // 學制欄位，依資料類型分
        $this->columnsCollection = collect([
            'quota' => [
                'school_code', //學校代碼
                'type_id',
                'last_year_admission_amount', //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
                'last_year_surplus_admission_quota', //上學年本地生未招足名額（二技參照學士）
                'ratify_expanded_quota', //本學年教育部核定擴增名額（二技參照學士）
                'created_by', //按下送出的人是誰
                'ip_address', //按下送出的人的IP
                'info_status', //waiting|confirmed|editing|returned
                'quota_status', //waiting|confirmed|editing|returned
                'review_memo', //讓學校再次修改的原因
                'review_by', //海聯回覆的人員
                'review_at', //海聯回覆的時間點
            ],
            'info' => [
                'school_code', //學校代碼
                'type_id',
                'description', //學制描述
                'eng_description', //'學制描述
                'created_by', //按下送出的人是誰
                'ip_address', //按下送出的人的IP
                'info_status', //waiting|confirmed|editing|returned
                'quota_status', //waiting|confirmed|editing|returned
                'review_memo', //讓學校再次修改的原因
                'review_by', //海聯回覆的人員
                'review_at', //海聯回覆的時間點
            ]
        ]);

        // 系所名額欄位，依學制分
        $this->departmentQuotaColumnsCollection = collect([
            1 => [
                'id',
                'school_code',
                'sort_order',
                'title',
                'eng_title',
                'has_special_class',
                'has_self_enrollment',
                'self_enrollment_quota',
                'admission_selection_quota',
                'last_year_admission_placement_quota', // 學士班才有
                'last_year_admission_placement_amount', // 學士班才有
                'admission_placement_quota', // 學士班才有
                'decrease_reason_of_admission_placement', // 學士班才有
                'created_at',
                'created_by',
                'info_status', //waiting|confirmed|editing|returned
                'quota_status', //waiting|confirmed|editing|returned
            ],
            2 => [
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
                'info_status', //waiting|confirmed|editing|returned
                'quota_status', //waiting|confirmed|editing|returned
            ],
            3 => [
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
                'info_status', //waiting|confirmed|editing|returned
                'quota_status', //waiting|confirmed|editing|returned
            ],
            4 => [
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
                'info_status', //waiting|confirmed|editing|returned
                'quota_status', //waiting|confirmed|editing|returned
            ]
        ]);

        // 系所資訊欄位
        $this->departmentInfoColumns = [
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
                'info_status', //waiting|confirmed|editing|returned
                'quota_status', //waiting|confirmed|editing|returned
        ];

        // 系所函式名反查
        $this->departmentsKeyCollection = collect([
            1 => 'bachelor_departments',
            2 => 'two_year_tech_departments',
            3 => 'master_departments',
            4 => 'phd_departments'
        ]);
    }

    /**
     * 取得學制資訊的歷史版本
     *
     * @param  string $school_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $school_id, $system_id, $histories_id)
    {
        $user = Auth::user();

        // 分辨要求為名額或資料
        $dataType = $request->query('data_type');

        // 確認使用者權限
        if ($user->can('view_info', [SystemHistoryData::class, $school_id, $dataType, $histories_id])) {
            // 設定 school id（可能是 me）
            $school_id = $user->school_editor->school_code;

            // mapping 學制 id
            $system_id = $this->systemIdCollection->get($system_id, 0);

            if ($system_id == 0) {
                $messages = array('System history version not found.');
                return response()->json(compact('messages'), 404);
            }

            // 擷取資料，並依照學制取得其下所有 $user 擁有權限的系所的 info
            $departmentKey = $this->departmentsKeyCollection->get($system_id);

            if ($user->school_editor->has_admin) {
                $departmentsWith = [
                    $departmentKey => function($query) {
                        $query->select($this->departmentInfoColumns)->with('creator.school_editor');
                    }
                ];
            } else {
                $departmentsWith = [
                    $departmentKey => function ($query) {
                        $query->select($this->departmentInfoColumns)->with('creator.school_editor')->whereHas('editor_permission', function ($query1) {
                            $query1->where('username', '=', Auth::id());
                        });
                    }
                ];
            }

            // 依照要求拿取資料
            $data = SystemHistoryData::select($this->columnsCollection->get('info'))
                ->where('school_code', '=', $school_id)
                ->where('type_id', '=', $system_id)
                ->with(
                    [
                        'type',
                        'creator.school_editor',
                        'reviewer.admin'
                    ] + $departmentsWith
                )
                ->latest()
                ->first();

            if ($data) {
                // 系所資料彙整至同一欄位
                $data->departments = $data->$departmentKey;
                unset($data->$departmentKey);

                return response()->json($data, 200);
            } else {
                $messages = array('System Data Not Found!');
                return response()->json(compact('messages'), 404);
            }
        } else if ($user->can('view_quota', [SystemHistoryData::class, $school_id, $dataType, $histories_id])) {
            $school_id = $user->school_editor->school_code;

            // mapping 學制 id (預設為 0)
            $system_id = $this->systemIdCollection->get($system_id, 0);

            if ($system_id == 0) {
                $messages = array('System history version not found.');

                return response()->json(compact('messages'), 404);
            }

            // 擷取資料，並依照學制取得其下所有系所名額資訊
            $departmentKey = $this->departmentsKeyCollection->get($system_id);
            $departmentQuotaColumns = $this->departmentQuotaColumnsCollection->get($system_id);

            $data = SystemHistoryData::select($this->columnsCollection->get('quota'))
                ->where('school_code', '=', $school_id)
                ->where('type_id', '=', $system_id)
                ->with([
                    'type',
                    'creator.school_editor',
                    'reviewer.admin',
                    $departmentKey => function($query) use ($departmentQuotaColumns) {
                        $query->select($departmentQuotaColumns)->with('creator.school_editor');
                    }
                ])
                ->latest()
                ->first();

            if ($data) {
                // 系所資料彙整至同一欄位
                $data->departments = $data->$departmentKey;
                unset($data->$departmentKey);

                return response()->json($data, 200);
            } else {
                $messages = array('System Data Not Found!');
                return response()->json(compact('messages'), 404);
            }
        } else {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }
    }

    /**
     * 新增學制資料歷史版本
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $school_id, $system_id)
    {
        $user = Auth::user();

        // 分辨要求為名額或資料
        $dataType = $request->query('data_type');

        // 確認使用者權限
        if ($user->can('create_info', [SystemHistoryData::class, $school_id, $dataType])) {
            // 設定 school id（可能是 me）
            $school_id = $user->school_editor->school_code;

            // mapping 學制 id（預設為 0）
            $system_id = $this->systemIdCollection->get($system_id, 0);

            if ($system_id == 0) {
                $messages = array('System history version not found.');
                return response()->json(compact('messages'), 404);
            }

            // 取得最新歷史版本
            $historyData = SystemHistoryData::select()
                ->where('school_code', '=', $school_id)
                ->where('type_id', '=', $system_id)
                ->latest()
                ->first();

            // 無歷史版本 => 無此學制
            if ($historyData == NULL) {
                $messages = array('System history version not found.');
                return response()->json(compact('messages'), 404);
            }

            // 確認歷史版本是否被 lock
            $historyInfoStatus = $historyData->info_status;
            if ($this->isLockedCollection->contains($historyInfoStatus)) {
                $messages = array('Data is locked');
                return response()->json(compact('messages'), 403);
            }

            // 分辨動作為儲存還是送出
            if ($request->input('action') == 'commit') {
                $infoStatus = 'waiting';
            } else {
                $infoStatus = 'editing';
            }

            // 設定資料驗證欄位
            $validationRules = array(
                'action' => 'required|in:save,commit|string', //動作
                'description' => 'required|string', //學制敘述
                'eng_description' => 'required|string' //學制英文敘述
            );

            // 驗證輸入資料
            $validator = Validator::make($request->all(), $validationRules);

            // 輸入資料驗證沒過
            if ($validator->fails()) {
                $messages = $validator->errors()->all();
                return response()->json(compact('messages'), 400);
            }

            // 整理輸入資料
            $insertData = array(
                'school_code' => $school_id,
                'type_id' => $system_id,
                'info_status' => $infoStatus,
                'created_by' => $user->username,
                'ip_address' => $request->ip(),
                // 不可修改的資料承襲上次版本內容
                'quota_status' => $historyData->quota_status,
                'last_year_admission_amount' => $historyData->last_year_admission_amount,
                'ratify_expanded_quota' => $historyData->ratify_expanded_quota,
                // 可修改的資料
                'action' => $request->input('action'),
                'description' => $request->input('description'),
                'eng_description' => $request->input('eng_description')
            );

            // 寫入資料
            $resultData = SystemHistoryData::create($insertData);

            // TODO 回傳結果要包含系所檢表 like getInfoDataWithDepartments()

            // 回傳剛建立的資料
            return response()->json($this->getDataById($resultData->history_id, 'info'), 201);
        } else if ($user->can('create_quota', [SystemHistoryData::class, $school_id, $dataType])) {
            $school_id = $user->school_editor->school_code;

            // mapping 學制 id (預設為 0)∂
            $system_id = $this->systemIdCollection->get($system_id, 0);

            if ($system_id == 0) {
                $messages = array('System history version not found.');
                return response()->json(compact('messages'), 404);
            }

            // 取得最新歷史版本
            $historyData = SystemHistoryData::select()
                ->where('school_code', '=', $school_id)
                ->where('type_id', '=', $system_id)
                ->latest()
                ->first();

            // TODO 要包含所有系所名額
            // TODO 要檢查名額總量（二技與學士班共用）
            // TODO 要檢查學校有無開放自招
            // TODO 要檢查系所有無開放自招（二技很複雜）
            // TODO 要可以控制系所的自招與否？（二技很複雜）
            // TODO 要檢查學士班聯合分發總量是否低於去年

            $historyQuotaStatus = $historyData->quota_status;

            // 確認歷史版本是否被 lock
            if ($this->isLockedCollection->contains($historyQuotaStatus)) {
                $messages = array('Data is locked');
                return response()->json(compact('messages'), 403);
            }

            // 分辨動作為儲存還是送出
            if ($request->input('action') == 'commit') {
                $quotaStatus = 'waiting';
            } else {
                $quotaStatus = 'editing';
            }

            // 取得學校資料歷史版本
            $schoolHistoryData = SchoolHistoryData::select()
                ->where('id', '=', $school_id)
                ->latest()
                ->first();

            if ($system_id == 1) { // 學士學制
                // 取得系所資料歷史版本 TODO 這樣只有拿到一筆系所資料，應該要
                $departmentHistoryData = DepartmentHistoryData::select()
                    ->where('school_code', '=', $school_id)
                    ->latest()
                    ->first();

                // 設定資料驗證欄位
                $validationRules = [
                    'action' => 'required|in:save,commit|string', //動作
                    'last_year_surplus_admission_quota' => 'required|integer', // 未招足名額
                    'departments' => 'required',
                    'departments.*.id' => [
                        'required',
                        'string',
                        Rule::exists('department_data', 'id')->where(function ($query) use ($school_id) {
                            $query->where('school_code', $school_id);
                        })
                    ],
                    'departments.*.has_self_enrollment' => 'required|boolean',
                    'departments.*.self_enrollment_quota' => 'required_if:has_self_enrollment,true|integer',
                    'departments.*.admission_selection_quota' => 'required|integer',
                    'departments.*.admission_placement_quota' => 'required|integer',
                    'departments.*.decrease_reason_of_admission_placement' =>
                        'if_reason_required:admission_placement_quota,'.$departmentHistoryData->last_year_admission_placement_quota.','.$departmentHistoryData->last_year_admission_placement_amount.'|string',
                ];

            } else if ($system_id == 2) {
                // 設定資料驗證欄位
                $validationRules = [
                    'action' => 'required|in:save,commit|string', //動作
                    'departments' => 'required',
                    'departments.*.id' => [
                        'required',
                        'string',
                        Rule::exists('two_year_tech_department_history_data', 'id')->where(function ($query) use ($school_id) {
                            $query->where('school_code', $school_id);
                        })
                    ],
                    'departments.*.has_self_enrollment' => 'required|boolean',
                    'departments.*.self_enrollment_quota' => 'required_if:has_self_enrollment,true|integer',
                    'departments.*.admission_selection_quota' => 'required|integer'
                ];
            } else {
                // 設定資料驗證欄位
                $validationRules = [
                    'action' => 'required|in:save,commit|string', //動作
                    'departments' => 'required',
                    'departments.*.id' => [
                        'required',
                        'string',
                        Rule::exists('graduate_department_history_data', 'id')->where(function ($query) use ($school_id) {
                            $query->where('school_code', $school_id);
                        })
                    ],
                    'departments.*.has_self_enrollment' => 'required|boolean',
                    'departments.*.self_enrollment_quota' => 'required_if:has_self_enrollment,true|integer',
                    'departments.*.admission_selection_quota' => 'required|integer'
                ];
            }

            // 驗證輸入資料
            $validator = Validator::make($request->all(), $validationRules);

            // 輸入資料驗證沒過
            if ($validator->fails()) {
                $messages = $validator->errors()->all();
                return response()->json(compact('messages'), 400);
            }

            // 整理輸入資料
            $InsertData = [
                'school_code' => $school_id,
                'type_id' => $system_id,
                'quota_status' => $quotaStatus,
                'created_by' => $user->username,
                'ip_address' => $request->ip(),
                // 不可修改的資料承襲上次版本內容
                'info_status' => $historyData->info_status,
                'description' => $historyData->description,
                'eng_description' => $historyData->eng_description,
                'last_year_admission_amount' => $historyData->last_year_admission_amount,
                'ratify_expanded_quota' => $historyData->ratify_expanded_quota,
                // 可修改的資料
                'action' => $request->input('action')
            ];

            // 二技班無 `last_year_surplus_admission_quota`（參照學士班）
            if ($system_id != 2) {
                $InsertData += array(
                    'last_year_surplus_admission_quota' => $request->input('last_year_surplus_admission_quota')
                );
            }

            // 整理系所輸入資料
            foreach ($request->input('departments') as $department) {
                // TODO 依照學制不同，將每個系所插入
                if ($system_id == 1) {
                    // 取得系所資料歷史版本 TODO 這樣只有拿到一筆系所資料，應該要
                    $departmentHistoryData = DepartmentHistoryData::select()
                        ->where('school_code', '=', $school_id)
                        ->latest()
                        ->first();

                    $departmentInsertData = [
                        'id' => $departmentHistoryData->id,
                        'school_code' => $departmentHistoryData->school_code,
                        'sort_order' => $departmentHistoryData->sort_order,
                        'title' => $departmentHistoryData->title,
                        'eng_title' => $departmentHistoryData->eng_title,
                        'has_special_class' => $departmentHistoryData->has_special_class,
                        'created_by' => $user->username,
                        'info_status' => $departmentHistoryData->info_status,
                        'quota_status' => $quotaStatus,
                        'last_year_surplus_admission_quota' => $department->last_year_surplus_admission_quota,
                        'admission_selection_quota' => $department->admission_selection_quota,
                        'admission_placement_quota' => $department->admission_placement_quota
                    ];

                    // 校有自招才可自招
                    if ($schoolHistoryData->has_self_enrollment) {
                        $departmentInsertData += array(
                            'has_self_enrollment' => $department->has_self_enrollment,
                            'self_enrollment_quota' => $department->self_enrollment_quota
                        );
                    }

                    // 本年度分發名額需比去年分發的名額與實際錄取量都還小，就得填減招原因
                    if ($department->admission_placement_quota < $departmentHistoryData->last_year_admission_placement_quota
                        && $department->admission_placement_quota < $departmentHistoryData->last_year_admission_placement_amount) {
                        $departmentInsertData += array(
                            'decrease_reason_of_admission_placement' => $department->decrease_reason_of_admission_placement
                        );
                    }
                } else if ($system_id == 2) {
                    // 取得系所資料歷史版本
                    $departmentHistoryData = TwoYearTechHistoryDepartmentData::select()
                        ->where('school_code', '=', $school_id)
                        ->latest()
                        ->first();

                    $departmentInsertData = [
                        'id' => $departmentHistoryData->id,
                        'school_code' => $departmentHistoryData->school_code,
                        'sort_order' => $departmentHistoryData->sort_order,
                        'title' => $departmentHistoryData->title,
                        'eng_title' => $departmentHistoryData->eng_title,
                        'has_special_class' => $departmentHistoryData->has_special_class,
                        'has_RiJian' => $departmentHistoryData->has_RiJian,
                        'created_by' => $user->username,
                        'info_status' => $departmentHistoryData->info_status,
                        'quota_status' => $quotaStatus
                    ];

                    // 校有自招才可自招
                    if ($schoolHistoryData->has_self_enrollment) {
                        // 有日間二技部，可自招可聯招
                        if ($departmentHistoryData->has_RiJian) {
                            $InsertData += [
                                'admission_selection_quota' => $department->admission_selection_quota,
                                'has_self_enrollment' => $department->has_self_enrollment,
                                'self_enrollment_quota' => $department->self_enrollment_quota
                            ];
                        } else {
                            // 沒日間二技部，有開專班，可聯招
                            if ($departmentHistoryData->has_special_class) {
                                $InsertData += [
                                    'admission_selection_quota' => $department->admission_selection_quota
                                ];
                            }
                        }
                    }
                } else {
                    // 碩博一樣
                    // 取得系所資料歷史版本
                    $departmentHistoryData = GraduateDepartmentHistoryData::select()
                        ->where('school_code', '=', $school_id)
                        ->where('system_id', '=', $system_id)
                        ->latest()
                        ->first();

                    $departmentInsertData = [
                        'id' => $departmentHistoryData->id,
                        'school_code' => $departmentHistoryData->school_code,
                        'system_id' => $system_id,
                        'sort_order' => $departmentHistoryData->sort_order,
                        'title' => $departmentHistoryData->title,
                        'eng_title' => $departmentHistoryData->eng_title,
                        'has_special_class' => $departmentHistoryData->has_special_class,
                        'created_by' => $user->username,
                        'info_status' => $departmentHistoryData->info_status,
                        'quota_status' => $quotaStatus,
                        'last_year_surplus_admission_quota' => $department->last_year_surplus_admission_quota,
                        'admission_selection_quota' => $department->admission_selection_quota
                    ];


                    // 校有自招才可自招
                    if ($schoolHistoryData->has_self_enrollment) {
                        $departmentInsertData += [
                            'has_self_enrollment' => $request->input('has_self_enrollment'),
                            'self_enrollment_quota' => $request->input('self_enrollment_quota')
                        ];
                    }
                }
            }

            // TODO 學制資訊依不同學制寫入不同張表
            $resultData = SystemHistoryData::create($InsertData);


            // 回傳剛建立的資料
            return response()->json($this->getDataById($resultData->history_id, 'quota'), 201);
        } else {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }
    }

    public function getDataById($id, $dataType)
    {
        // TODO 若最新資料為 editing or returned，review_by, review_at, review_memo 需為最新一筆狀態為 returned 的內容

        // 依照要求拿取資料
        return SystemHistoryData::select($this->columnsCollection->get($dataType))
            ->where('history_id', '=', $id)
            ->with('creator.school_editor', 'reviewer.admin')
            ->first();
    }
}
