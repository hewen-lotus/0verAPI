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
use App\TwoYearTechDepartmentData;
use App\TwoYearTechHistoryDepartmentData;
use App\GraduateDepartmentData;
use App\GraduateDepartmentHistoryData;
use App\DepartmentHistoryData;
use App\DepartmentData;

class SystemHistoryDataController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'switch']);

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
//                'self_enrollment_quota', // 不調查各系自招人數
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

            return $this->return_info($school_id, $system_id);
        } else if ($user->can('view_quota', [SystemHistoryData::class, $school_id, $dataType, $histories_id])) {
            $school_id = $user->school_editor->school_code;

            // mapping 學制 id (預設為 0)
            $system_id = $this->systemIdCollection->get($system_id, 0);

            if ($system_id == 0) {
                $messages = array('System history version not found.');

                return response()->json(compact('messages'), 404);
            }

            return $this->return_quota($school_id, $system_id);
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
                'eng_description' => 'string' //學制英文敘述
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

            return $this->return_info($school_id, $system_id, 201);
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

            // 依學制檢查名額量
            if ($system_id == 1) { // 學士學制名額驗證
                // 設定資料驗證欄位
                $validationRules = [
                    'action' => 'required|in:save,commit|string', //動作
                    'ratify_quota_for_self_enrollment' => 'required|integer', //學士班調查自招總量
                    'departments' => 'required|array',
                    'departments.*.id' => [
                        'required',
                        'string',
                        Rule::exists('department_data', 'id')->where(function ($query) use ($school_id) {
                            $query->where('school_code', $school_id);
                        })
                    ],
                    'departments.*.has_self_enrollment' => 'required|boolean',
//                    'departments.*.self_enrollment_quota' => 'required_if:has_self_enrollment,1|integer', // 學士班不調查各系自招人數
                    'departments.*.admission_selection_quota' => 'required|integer',
                    'departments.*.admission_placement_quota' => 'required|integer',
                    'departments.*.decrease_reason_of_admission_placement' =>
                        'if_decrease_reason_required:id,admission_placement_quota|nullable|string',
                ];

                // 可招生總量為 last_year_surplus_admission_quota + last_year_admission_amount + ratify_expanded_quota
                $total_can_Admissions = $historyData->last_year_surplus_admission_quota + $historyData->last_year_admission_amount + $historyData->ratify_expanded_quota;

                // 初始化欲招收總量
                $allQuota = 0;

                // 取得二技班資料歷史版本
                $two_years = TwoYearTechHistoryDepartmentData::where('school_code','=', $school_id)->get();

                // 累計二技班所有系所個人申請與自招量（校可自招且系有開自招才可加入計算）
                foreach ($two_years as $two_year) {
                    if ($schoolHistoryData->has_self_enrollment && $two_year->has_self_enrollment) {
                        $allQuota += $two_year->admission_selection_quota + $two_year->self_enrollment_quota;
                    } else {
                        $allQuota += $two_year->admission_selection_quota;
                    }
                }

                // 累計要求的學士班個人申請、聯合分發人數
                foreach ($request->input('departments') as &$department_item) {
                    $allQuota += $department_item['admission_selection_quota'] + $department_item['admission_placement_quota'];
                }

                // 累計學士班自招總量
                if ($schoolHistoryData->has_self_enrollment) {
                    $allQuota += $request->input('ratify_quota_for_self_enrollment', 0);
                }

                // 必須讓 學士所有系所的 (admission_selection_quota + admission_placement_quota) + 學士班自招總量 ratify_quota_for_self_enrollment + 二技所有系所的 (admission_selection_quota + self_enrollment_quota) <= 可招生總量
                if ($total_can_Admissions < $allQuota) {
                    $messages = array('各系所招生人數加總必須小於或等於可招生總量');
                    return response()->json(compact('messages'), 400);
                }
            } else if ($system_id == 2) { // 二技學制名額驗證
                // 設定資料驗證欄位
                $validationRules = [
                    'action' => 'required|in:save,commit|string', //動作
                    'departments' => 'required|array',
                    'departments.*.id' => [
                        'required',
                        'string',
                        Rule::exists('two_year_tech_department_data', 'id')->where(function ($query) use ($school_id) {
                            $query->where('school_code', $school_id);
                        })
                    ],
                    'departments.*.has_self_enrollment' => 'required|boolean',
                    'departments.*.self_enrollment_quota' => 'required_if:has_self_enrollment,1|integer',
                    'departments.*.admission_selection_quota' => 'required|integer'
                ];

                // 二技可招生總量參照學士班資料
                $deptsystemhistoryData = SystemHistoryData::select()
                    ->where('school_code', '=', $school_id)
                    ->where('type_id', '=', 1)
                    ->latest()
                    ->first();

                $total_can_Admissions = $deptsystemhistoryData->last_year_surplus_admission_quota + $deptsystemhistoryData->last_year_admission_amount + $deptsystemhistoryData->ratify_expanded_quota;

                // 初始化欲招收總量
                $allQuota = 0;

                // 取得學士班資料歷史版本
                $depts = DepartmentHistoryData::where('school_code','=', $school_id)->get();

                // 累計要求的學士班個人申請、聯合分發人數
                foreach ($depts as $dept) {
                    $allQuota += $allQuota += $dept->admission_selection_quota + $dept->admission_placement_quota;
                }

                // 累計學士班自招總量
                if ($schoolHistoryData->has_self_enrollment) {
                    $allQuota += $deptsystemhistoryData->ratify_quota_for_self_enrollment;
                }

                // 累計要求的二技班個人申請、聯合分發、自招量（校可自招且系有開自招才可加入計算）
                foreach ($request->input('departments') as &$department_item) {
                    if ($schoolHistoryData->has_self_enrollment && $department_item['has_self_enrollment']) {
                        $allQuota += $department_item['admission_selection_quota'] + $department_item['self_enrollment_quota'];
                    } else {
                        $allQuota += $department_item['admission_selection_quota'];
                    }
                }

                // 必須讓 學士所有系所的 (admission_selection_quota + admission_placement_quota) + 學士班自招總量 ratify_quota_for_self_enrollment + 二技所有系所的 (admission_selection_quota + self_enrollment_quota) <= 可招生總量
                if ($total_can_Admissions < $allQuota) {
                    $messages = array('各系所招生人數加總必須小於或等於可招生總量');
                    return response()->json(compact('messages'), 400);
                }
            } else {// 碩博學制名額驗證
                // 設定資料驗證欄位
                $validationRules = [
                    'action' => 'required|in:save,commit|string', //動作
                    'departments' => 'required|array',
                    'departments.*.id' => [
                        'required',
                        'string',
                        Rule::exists('graduate_department_data', 'id')->where(function ($query) use ($school_id) {
                            $query->where('school_code', $school_id);
                        })
                    ],
                    'departments.*.has_self_enrollment' => 'required|boolean',
                    'departments.*.self_enrollment_quota' => 'required_if:has_self_enrollment,1|nullable|integer',
                    'departments.*.admission_selection_quota' => 'required|integer'
                ];

                // 可招生總量為 last_year_surplus_admission_quota + last_year_admission_amount + ratify_expanded_quota
                $total_can_Admissions = $historyData->last_year_surplus_admission_quota + $historyData->last_year_admission_amount + $historyData->ratify_expanded_quota;

                // 初始化欲招收總量
                $allQuota = 0;

                // 累計要求的碩博班個人申請、聯合分發、自招量（校可自招且系有開自招才可加入計算）
                foreach ($request->input('departments') as &$department_item) {
                    if ($schoolHistoryData->has_self_enrollment && $department_item['has_self_enrollment']) {
                        $allQuota += $department_item['admission_selection_quota'] + $department_item['self_enrollment_quota'];
                    } else {
                        $allQuota += $department_item['admission_selection_quota'];
                    }
                }

                // 必須讓該學制所有系所的 admission_selection_quota + self_enrollment_quota <= 可招生總量
                if ($total_can_Admissions < $allQuota) {
                    $messages = array('各系所招生人數加總必須小於或等於可招生總量');
                    return response()->json(compact('messages'), 400);
                }
            }

            // 驗證輸入資料
            $validator = Validator::make($request->all(), $validationRules);

            // 輸入資料驗證沒過
            if ($validator->fails()) {
                $messages = $validator->errors()->all();
                return response()->json(compact('messages'), 400);
            }

            DB::transaction(function () use ($request, $system_id, $school_id, $user, $quotaStatus, $schoolHistoryData, $historyData){
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

                // 學士班特別資料整理
                if ($system_id == 1) {
                    // 若校可自招，則寫入學士班自招總量
                    if ($schoolHistoryData->has_self_enrollment) {
                        $InsertData += [
                            'ratify_quota_for_self_enrollment' => $request->input('ratify_quota_for_self_enrollment')
                        ];
                    }
                }

                // 二技班無 `last_year_surplus_admission_quota`（參照學士班）
                if ($system_id != 2) {
                    $InsertData += [
                        'last_year_surplus_admission_quota' => $historyData->last_year_surplus_admission_quota
                    ];
                }

                // 寫入學制資料
                $newData = SystemHistoryData::create($InsertData);

                // 整理系所輸入資料
                foreach ($request->input('departments') as &$department) {
                    // 依照學制不同，將每個系所資料寫入
                    if ($system_id == 1) { // 學士班
                        // 取得最新版系所資料
                        $departmentHistoryData = DepartmentHistoryData::select()
                            ->where('school_code', '=', $school_id)
                            ->where('id', '=', $department['id'])
                            ->latest()
                            ->first();

                        if (!$departmentHistoryData) {
                            $messages = array('department history not found.');
                            return response()->json(compact('messages'), 404);
                        }

                        // 整理系所寫入資料
                        $departmentInsertData = [
                            'id' => $departmentHistoryData->id,
                            'card_code' => $departmentHistoryData->card_code,
                            'school_code' => $departmentHistoryData->school_code,
                            'special_dept_type' => $departmentHistoryData->special_dept_type,
                            'sort_order' => $departmentHistoryData->sort_order,
                            'title' => $departmentHistoryData->title,
                            'eng_title' => $departmentHistoryData->eng_title,
                            'description' => $departmentHistoryData->description,
                            'eng_description' => $departmentHistoryData->eng_description,
                            'memo' => $departmentHistoryData->memo,
                            'eng_memo' => $departmentHistoryData->eng_memo,
                            'url' => $departmentHistoryData->url,
                            'eng_url' => $departmentHistoryData->eng_url,
                            'gender_limit' => $departmentHistoryData->gender_limit,
                            'rank' => $departmentHistoryData->rank,
                            'has_review_fee' => $departmentHistoryData->has_review_fee,
                            'review_fee_detail' => $departmentHistoryData->review_fee_detail,
                            'eng_review_fee_detail' => $departmentHistoryData->has_birth_limit,
                            'has_birth_limit' => $departmentHistoryData->has_birth_limit,
                            'birth_limit_after' => $departmentHistoryData->birth_limit_after,
                            'birth_limit_before' => $departmentHistoryData->birth_limit_before,
                            'main_group' => $departmentHistoryData->main_group,
                            'sub_group' => $departmentHistoryData->sub_group,
                            'has_eng_taught' => $departmentHistoryData->has_eng_taught,
                            'has_disabilities' => $departmentHistoryData->has_disabilities,
                            'has_BuHweiHwaWen' => $departmentHistoryData->has_BuHweiHwaWen,
                            'evaluation' => $departmentHistoryData->evaluation,
                            'last_year_admission_placement_amount' => $departmentHistoryData->last_year_admission_placement_amount,
                            'last_year_admission_placement_quota' => $departmentHistoryData->last_year_admission_placement_quota,
                            'last_year_personal_apply_offer' => $departmentHistoryData->last_year_personal_apply_offer,
                            'last_year_personal_apply_amount' => $departmentHistoryData->last_year_personal_apply_amount,
                            'has_special_class' => $departmentHistoryData->has_special_class,
                            'has_foreign_special_class' => $departmentHistoryData->has_foreign_special_class,
                            'created_by' => $user->username,
                            'ip_address' => $request->ip(),
                            'info_status' => $departmentHistoryData->info_status,
                            'quota_status' => $quotaStatus,
                            'admission_selection_quota' => $department['admission_selection_quota'],
                            'admission_placement_quota' => $department['admission_placement_quota']
                        ];

                        // 校有自招且系要自招才可自招，否則自招資訊重設
                        if ($schoolHistoryData->has_self_enrollment && $department['has_self_enrollment']) {
                            $departmentInsertData += [
                                'has_self_enrollment' => $department['has_self_enrollment'],
//                                'self_enrollment_quota' => $department['self_enrollment_quota'] // 學士班不調查各系自招人數
                            ];
                        } else {
                            $departmentInsertData += [
                                'has_self_enrollment' => false,
//                                'self_enrollment_quota' => NULL // 學士班不調查各系自招人數
                            ];
                        }

                        // 本年度分發名額需比去年分發的名額與實際錄取量都還小，就得填減招原因
                        if ($department['admission_placement_quota'] < $departmentHistoryData->last_year_admission_placement_quota
                            && $department['admission_placement_quota'] < $departmentHistoryData->last_year_admission_placement_amount
                        ) {
                            $departmentInsertData += array(
                                'decrease_reason_of_admission_placement' => $department['decrease_reason_of_admission_placement']
                            );
                        }

                        // 寫入名額資訊
                        DepartmentHistoryData::create($departmentInsertData);
                    } else if ($system_id == 2) { // 二技班
                        // 取得最新版系所資料
                        $departmentHistoryData = TwoYearTechHistoryDepartmentData::select()
                            ->where('school_code', '=', $school_id)
                            ->where('id', '=', $department['id'])
                            ->latest()
                            ->first();

                        if (!$departmentHistoryData) {
                            $messages = array('department history not found.');
                            return response()->json(compact('messages'), 404);
                        }

                        // 整理系所寫入資料
                        $departmentInsertData = [
                            'id' => $departmentHistoryData->id,
                            'special_dept_type' => $departmentHistoryData->special_dept_type,
                            'school_code' => $departmentHistoryData->school_code,
                            'sort_order' => $departmentHistoryData->sort_order,
                            'title' => $departmentHistoryData->title,
                            'eng_title' => $departmentHistoryData->eng_title,
                            'description' => $departmentHistoryData->description,
                            'eng_description' => $departmentHistoryData->eng_description,
                            'memo' => $departmentHistoryData->memo,
                            'eng_memo' => $departmentHistoryData->eng_memo,
                            'url' => $departmentHistoryData->url,
                            'eng_url' => $departmentHistoryData->eng_url,
                            'last_year_personal_apply_offer' => $departmentHistoryData->last_year_personal_apply_offer,
                            'last_year_personal_apply_amount' => $departmentHistoryData->last_year_personal_apply_amount,
                            'has_self_enrollment' => $departmentHistoryData->has_self_enrollment,
                            'has_special_class' => $departmentHistoryData->has_special_class,
                            'approve_no_of_special_class' => $departmentHistoryData->approve_no_of_special_class,
                            'approval_doc_of_special_class' => $departmentHistoryData->approval_doc_of_special_class,
                            'self_enrollment_quota' => $departmentHistoryData->self_enrollment_quota,
                            'has_review_fee' => $departmentHistoryData->has_review_fee,
                            'review_fee_detail' => $departmentHistoryData->review_fee_detail,
                            'eng_review_fee_detail' => $departmentHistoryData->eng_review_fee_detail,
                            'has_birth_limit' => $departmentHistoryData->has_birth_limit,
                            'birth_limit_after' => $departmentHistoryData->birth_limit_after,
                            'birth_limit_before' => $departmentHistoryData->birth_limit_before,
                            'main_group' => $departmentHistoryData->main_group,
                            'sub_group' => $departmentHistoryData->sub_group,
                            'has_eng_taught' => $departmentHistoryData->has_eng_taught,
                            'has_disabilities' => $departmentHistoryData->has_disabilities,
                            'has_BuHweiHwaWen' => $departmentHistoryData->has_BuHweiHwaWen,
                            'evaluation' => $departmentHistoryData->evaluation,
                            'has_RiJian' => $departmentHistoryData->has_RiJian,
                            'gender_limit' => $departmentHistoryData->gender_limit,
                            'rank' => $departmentHistoryData->rank,
                            'created_by' => $user->username,
                            'ip_address' => $request->ip(),
                            'info_status' => $departmentHistoryData->info_status,
                            'quota_status' => $quotaStatus
                        ];

                        // 有 has_RiJian => 可個人申請可自招
                        // 沒 has_RiJian，但有 has_special_class => 可個人申請不可自招
                        // 沒 has_RiJian，也沒 has_special_class => 都不行

                        // 校有自招且系要自招才可自招，否則自招資訊重設
                        if ($schoolHistoryData->has_self_enrollment && $department['has_self_enrollment']) {
                            // 有日間二技部，可自招可聯招
                            if ($departmentHistoryData->has_RiJian) {
                                $departmentInsertData += [
                                    'admission_selection_quota' => $department['admission_selection_quota'],
                                    'self_enrollment_quota' => $department['self_enrollment_quota']
                                ];
                            } else {
                                // 沒日間二技部，有開專班，可聯招
                                if ($departmentHistoryData->has_special_class) {
                                    $departmentInsertData += [
                                        'admission_selection_quota' => $department['admission_selection_quota']
                                    ];
                                }
                            }
                        } else {
                            $departmentInsertData += array(
                                'has_self_enrollment' => false,
                                'self_enrollment_quota' => NULL
                            );
                        }

                        // 寫入名額資訊
                        TwoYearTechHistoryDepartmentData::create($departmentInsertData);
                    } else { // 碩博學制
                        // 取得最新版系所資料
                        $departmentHistoryData = GraduateDepartmentHistoryData::select()
                            ->where('school_code', '=', $school_id)
                            ->where('id', '=', $department['id'])
                            ->where('system_id', '=', $system_id)
                            ->latest()
                            ->first();

                        if (!$departmentHistoryData) {
                            $messages = array('department history not found.');
                            return response()->json(compact('messages'), 404);
                        }

                        // 整理系所寫入資料
                        $departmentInsertData = [
                            'id' => $departmentHistoryData->id,
                            'school_code' => $departmentHistoryData->school_code,
                            'system_id' => $system_id,
                            'special_dept_type' => $departmentHistoryData->special_dept_type,
                            'sort_order' => $departmentHistoryData->sort_order,
                            'title' => $departmentHistoryData->title,
                            'eng_title' => $departmentHistoryData->eng_title,
                            'description' => $departmentHistoryData->description,
                            'eng_description' => $departmentHistoryData->eng_description,
                            'memo' => $departmentHistoryData->memo,
                            'eng_memo' => $departmentHistoryData->eng_memo,
                            'url' => $departmentHistoryData->url,
                            'eng_url' => $departmentHistoryData->eng_url,
                            'last_year_personal_apply_offer' => $departmentHistoryData->last_year_personal_apply_offer,
                            'last_year_personal_apply_amount' => $departmentHistoryData->last_year_personal_apply_amount,
                            'has_self_enrollment' => $departmentHistoryData->has_self_enrollment,
                            'has_special_class' => $departmentHistoryData->has_special_class,
                            'has_foreign_special_class' => $departmentHistoryData->has_foreign_special_class,
                            'gender_limit' => $departmentHistoryData->gender_limit,
                            'rank' => $departmentHistoryData->rank,
                            'has_review_fee' => $departmentHistoryData->has_review_fee,
                            'review_fee_detail' => $departmentHistoryData->review_fee_detail,
                            'eng_review_fee_detail' => $departmentHistoryData->eng_review_fee_detail,
                            'has_birth_limit' => $departmentHistoryData->has_birth_limit,
                            'birth_limit_after' => $departmentHistoryData->birth_limit_after,
                            'birth_limit_before' => $departmentHistoryData->birth_limit_before,
                            'created_by' => $user->username,
                            'main_group' => $departmentHistoryData->main_group,
                            'sub_group' => $departmentHistoryData->sub_group,
                            'has_eng_taught' => $departmentHistoryData->has_eng_taught,
                            'has_disabilities' => $departmentHistoryData->has_disabilities,
                            'has_BuHweiHwaWen' => $departmentHistoryData->has_BuHweiHwaWen,
                            'evaluation' => $departmentHistoryData->evaluation,
                            'has_RiJian' => $departmentHistoryData->has_RiJian,
                            'ip_address' => $request->ip(),
                            'info_status' => $departmentHistoryData->info_status,
                            'quota_status' => $quotaStatus,
                            'admission_selection_quota' => $department['admission_selection_quota']
                        ];

                        // 校有自招且系要自招才可自招，否則自招資訊重設
                        if ($schoolHistoryData->has_self_enrollment && $department['has_self_enrollment']) {
                            $departmentInsertData += [
                                'has_self_enrollment' => $department['has_self_enrollment'],
                                'self_enrollment_quota' => $department['self_enrollment_quota']
                            ];
                        }

                        // 寫入名額資料
                        GraduateDepartmentHistoryData::create($departmentInsertData);
                    }
                }

                return $newData;
            });

            return $this->return_quota($school_id, $system_id, 201);
        } else {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }
    }

    public function return_quota($school_id, $system_id, $status_code = 200)
    {
        // 擷取資料，並依照學制
        $data = SystemHistoryData::select($this->columnsCollection->get('quota'))
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', $system_id)
            ->with('type', 'creator.school_editor', 'reviewer.admin')
            ->latest()
            ->first();

        // 沒有學制資訊？404 啦
        if ($data == NULL) {
            $messages = array('System Data Not Found!');
            return response()->json(compact('messages'), 404);
        }

        // 若為二技學制，則 last_year_surplus_admission_quota、last_year_admission_amount、ratify_expanded_quota 要從學士的資料拿
        if ($system_id == 2) {
            $anotherSystemData = SystemHistoryData::select($this->columnsCollection->get('quota'))
                ->where('school_code', '=', $school_id)
                ->where('type_id', '=', 1)
                ->latest()
                ->first();

            $data->last_year_surplus_admission_quota = $anotherSystemData->last_year_surplus_admission_quota;
            $data->last_year_admission_amount = $anotherSystemData->last_year_admission_amount;
            $data->ratify_expanded_quota = $anotherSystemData->ratify_expanded_quota;
            // 需要學士班自招總量
            $data->ratify_quota_for_self_enrollment = $anotherSystemData->ratify_quota_for_self_enrollment;
        }

        // 依學制設定系所資料模型
        if ($system_id == 1) {
            $DepartmentHistoryData = new DepartmentHistoryData();
            $DepartmentData = new DepartmentData();

            $AnotherDepartmentHistoryData = new TwoYearTechHistoryDepartmentData();
            $AnotherDepartmentData = new TwoYearTechDepartmentData();
        } else if ($system_id == 2) {
            $DepartmentHistoryData = new TwoYearTechHistoryDepartmentData();
            $DepartmentData = new TwoYearTechDepartmentData();

            $AnotherDepartmentHistoryData = new DepartmentHistoryData();
            $AnotherDepartmentData = new DepartmentData();
        } else {
            $DepartmentHistoryData = new GraduateDepartmentHistoryData();
            $DepartmentData = new GraduateDepartmentData();
        }

        // 從主表取得系所列表
        if ($system_id == 3 || $system_id == 4) {
            // 碩博同表，需多加規則
            $departmentsList = $DepartmentData::select('id')
                ->where('school_code', '=', $school_id)
                ->where('system_id', '=', $system_id)
                ->get();
        } else {
            // 學士二技各自有表
            $departmentsList = $DepartmentData::select('id')
                ->where('school_code', '=', $school_id)
                ->get();
            // 需取得另一個學制的系所列表
            $anotherDepartmentsList = $AnotherDepartmentData::select('id')
                ->where('school_code', '=', $school_id)
                ->get();
        }

        // 取得使用者有權限閱覽的系所資料
        $departmentQuotaColumns = $this->departmentQuotaColumnsCollection->get($system_id);
        $departmentHistoryList = [];
        foreach ($departmentsList as $dept) {
            $deptHistoryData = $DepartmentHistoryData::select($departmentQuotaColumns)
                ->where('id', '=', $dept['id'])
                ->with('creator.school_editor')
                ->latest()
                ->first();

            array_push($departmentHistoryList, $deptHistoryData);
        }

        $data->departments = $departmentHistoryList;

        // 若為學士或二技，要拿到另一個學制的自招額度總和跟個人申請總和
        if ($system_id == 1 || $system_id == 2) {
            $anotherDepartmentSelfEnrollmentQuota = 0;
            $anotherDepartmentAdmissionSelectionQuota = 0;
            $anotherDepartmentAdmissionPlacementQuota = 0;

            if ($system_id == 2) {
                // 學士班自招人數總量要從學制資訊拿
                $anotherDepartmentSelfEnrollmentQuota = $deptsystemhistoryData->ratify_quota_for_self_enrollment;
            }
            
            foreach ($anotherDepartmentsList as $dept) {
                $deptHistoryData = $AnotherDepartmentHistoryData::select()
                    ->where('id', '=', $dept['id'])
                    ->with('creator.school_editor')
                    ->latest()
                    ->first();

                if ($system_id == 1) {
                    // 若是學士班，則累計二技有自招的自招名額
                    if ($deptHistoryData->has_enrollment) {
                        $anotherDepartmentSelfEnrollmentQuota += $deptHistoryData->self_enrollment_quota;
                    }
                } else if ($system_id == 2) {
                    // 若是二技，則累計學士分發總數
                    $anotherDepartmentAdmissionPlacementQuota += $deptHistoryData->admission_placement_quota;
                }

                // 累計個人申請名額
                $anotherDepartmentAdmissionSelectionQuota += $deptHistoryData->admission_selection_quota;
            }

            $data->another_department_self_enrollment_quota = $anotherDepartmentSelfEnrollmentQuota;
            $data->another_department_admission_selection_quota = $anotherDepartmentAdmissionSelectionQuota;
            // 若是要求是二技學制，則應給學士學制分發總數
            if ($system_id == 2) {
                $data->another_department_admission_placement_quota = $anotherDepartmentAdmissionPlacementQuota;
            }
        }

        // 要拿到該校的 has_enrollment
        $schoolHistoryData = SchoolHistoryData::select('has_self_enrollment')
            ->where('id', '=', $school_id)
            ->latest()
            ->first();

        $data->school_has_self_enrollment = $schoolHistoryData->has_self_enrollment;

        return response()->json($data, $status_code);
    }

    public function return_info($school_id, $system_id, $status_code = 200)
    {
        $user = Auth::user();

        // 依照要求拿取學制資料
        $data = SystemHistoryData::select($this->columnsCollection->get('info'))
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', $system_id)
            ->with('type', 'creator.school_editor', 'reviewer.admin')
            ->latest()
            ->first();

        // 沒有學制資訊？404 啦
        if ($data == NULL) {
            $messages = array('System Data Not Found!');
            return response()->json(compact('messages'), 404);
        }

        // 取得使用者有權限的系所
        $permissionsDepartments = SchoolEditor::select()
            ->where('username', '=', $user->username)
            ->with('department_permissions')
            ->first()
            ->department_permissions->map(function ($item) {
                return $item->dept_id;
            });

        // 依學制設定資料模型
        if ($system_id == 1) {
            $DepartmentHistoryData = new DepartmentHistoryData();
            $DepartmentData = new DepartmentData();
        } else if ($system_id == 2) {
            $DepartmentHistoryData = new TwoYearTechHistoryDepartmentData();
            $DepartmentData = new TwoYearTechDepartmentData();
        } else {
            $DepartmentHistoryData = new GraduateDepartmentHistoryData();
            $DepartmentData = new GraduateDepartmentData();
        }

        // 取得系所列表
        if ($system_id == 3 || $system_id == 4) {
            // 碩博同表，需多加規則
            $departmentsList = $DepartmentData::select('id')
                ->where('school_code', '=', $school_id)
                ->where('system_id', '=', $system_id)
                ->get();
        } else {
            // 學士二技各自有表
            $departmentsList = $DepartmentData::select('id')
                ->where('school_code', '=', $school_id)
                ->get();
        }
        // 取得使用者有權限閱覽的系所資料
        $departmentHistoryList = [];
        foreach ($departmentsList as $dept) {
            $deptHistoryData = $DepartmentHistoryData::select($this->departmentInfoColumns)
                ->where('id', '=', $dept['id'])
                ->with('creator.school_editor')
                ->latest()
                ->first();

            // 編輯管理員有權看所有系所
            if ($user->school_editor->has_admin || $permissionsDepartments->has($dept['id'])) {
                array_push($departmentHistoryList, $deptHistoryData);
            }
        }

        $data->departments = $departmentHistoryList;

        return response()->json($data, $status_code);
    }
}
