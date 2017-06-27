<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

//use App\SchoolEditor;
use App\SchoolHistoryData;
use App\SystemHistoryData;
//use App\DepartmentData;
use App\DepartmentHistoryData;
//use App\TwoYearTechDepartmentData;
use App\TwoYearTechHistoryDepartmentData;
//use App\GraduateDepartmentData;
use App\GraduateDepartmentHistoryData;

/**
 * Class DepartmentHistoryDataController
 * @package App\Http\Controllers
 */

class DepartmentHistoryDataController extends Controller
{
    /**
     * DepartmentHistoryDataController constructor.
     */
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
    }

    /**
     * @param $school_id
     * @param $system_id
     * @param $department_id
     * @param $histories_id
     * @return \Illuminate\Http\JsonResponse
     */
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

        // 依學制設定 Model
        if ($system_id == 1) {
            $Model = DepartmentHistoryData::class;
        } else if ($system_id == 2) {
            $Model = TwoYearTechHistoryDepartmentData::class;
        } else {
            $Model = GraduateDepartmentHistoryData::class;
        }

        // 依學制驗證權限
        if ($user->can('view', [$Model, $school_id, $department_id])) {
            // 依照要求拿取系所資料
            return response()->json($this->getData($system_id, $department_id), 200);
        } else {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }
    }

    /**
     * @param Request $request
     * @param $school_id
     * @param $system_id
     * @param $department_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $school_id, $system_id, $department_id)
    {

        // TODO 缺備審資料

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

        // 依學制設定 Model
        if ($system_id == 1) {
            $Model = DepartmentHistoryData::class;
        } else if ($system_id == 2) {
            $Model = TwoYearTechHistoryDepartmentData::class;
        } else {
            $Model = GraduateDepartmentHistoryData::class;
        }

        // 依學制驗證權限
        if (!$user->can('create', [$Model, $school_id, $department_id])) {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }

        // 取得最新歷史版本
        $historyData = $this->getData($system_id, $department_id);

        // 取得最新歷史版本資料狀態
        $historyInfoStatus = $historyData->info_status;
        $historyQuotaStatus = $historyData->quota_status;

        // 確認最新歷史版本是否被 lock
        if ($this->isLockedCollection->contains($historyInfoStatus)) {
            $messages = array('Data is locked');
            return response()->json(compact('messages'), 403);
        }

        // 分辨動作為儲存還是送出
        if ($request->input('action') == 'commit') {
            $status = 'waiting';
        } else {
            $status = 'editing';
        }

        // 設定資料驗證欄位
        if ($request->input('action') == 'commit') {
            // 送出需要驗證所有欄位
            $validationRules = [
                'action' => 'required|in:save,commit|string', //動作
                'sort_order' => 'required|integer', //系所顯示排序
                'description' => 'required|string', //系所敘述
                'eng_description' => 'present|string', //學制英文敘述
                'memo' => 'present|nullable|string', //給海聯備註
                'url' => 'required|url', //學校網站網址
                'eng_url' => 'present|url', //學校英文網站網址
                'gender_limit' => 'required|in:NULL,M,F', //性別限制
                'has_foreign_special_class' => 'required|boolean', //是否招收外生專班
                'has_eng_taught' => 'required|boolean', //是否為全英文授課
                'has_disabilities' => 'required|boolean', //是否招收身障學生
                'has_BuHweiHwaWen' => 'required|boolean', //是否招收不具華文基礎學生
                'has_birth_limit' => 'required|boolean', //是否限制出生日期
                'has_review_fee' => 'required|boolean', //是否另外收取審查費用
                'review_fee_detail' => 'required_if:has_review_fee,1|string', //審查費用說明
                'eng_review_fee_detail' => 'required_if:has_review_fee,1|nullable|string', //審查費用英文說明
                'birth_limit_after' => 'required_if:has_birth_limit,1|nullable|birth_limit_date_format:"Y-m-d"', //限...之後出生 年月日 `1991-02-23`
                'birth_limit_before' => 'required_if:has_birth_limit,1|nullable|birth_limit_date_format:"Y-m-d', //限...之前出生 年月日 `1991-02-23`
                'main_group' => 'required|exists:department_groups,id', //主要隸屬學群 id
                'sub_group' => 'required|nullable|exists:department_groups,id', //次要隸屬學群 id
                'evaluation' => 'required|exists:evaluation_levels,id', //系所評鑑等級 id
                'admission_selection_quota' => 'required|integer', //個人申請名額
            ];
        } else {
            // 儲存不驗證欄位是否為空值
            $validationRules = [
                'action' => 'required|in:save,commit|string', //動作
                'sort_order' => 'required|integer', //系所顯示排序
                'description' => 'present|string', //系所敘述
                'eng_description' => 'present|string', //學制英文敘述
                'memo' => 'present|nullable|string', //給海聯備註
                'url' => 'present|url', //學校網站網址
                'eng_url' => 'present|url', //學校英文網站網址
                'gender_limit' => 'required|in:NULL,M,F', //性別限制
                'has_foreign_special_class' => 'required|boolean', //是否招收外生專班
                'has_eng_taught' => 'required|boolean', //是否為全英文授課
                'has_disabilities' => 'required|boolean', //是否招收身障學生
                'has_BuHweiHwaWen' => 'required|boolean', //是否招收不具華文基礎學生
                'has_birth_limit' => 'required|boolean', //是否限制出生日期
                'has_review_fee' => 'required|boolean', //是否另外收取審查費用
                'review_fee_detail' => 'required_if:has_review_fee,1|nullable|string', //審查費用說明
                'eng_review_fee_detail' => 'required_if:has_review_fee,1|nullable|string', //審查費用英文說明
                'birth_limit_after' => 'required_if:has_birth_limit,1|nullable|birth_limit_date_format:"Y-m-d"', //限...之後出生 年月日 `1991-02-23`
                'birth_limit_before' => 'required_if:has_birth_limit,1|nullable|birth_limit_date_format:"Y-m-d', //限...之前出生 年月日 `1991-02-23`
                'main_group' => 'present|exists:department_groups,id', //主要隸屬學群 id
                'sub_group' => 'present|nullable|exists:department_groups,id', //次要隸屬學群 id
                'evaluation' => 'present|exists:evaluation_levels,id', //系所評鑑等級 id
                'admission_selection_quota' => 'present|integer', //個人申請名額
            ];
        }


        // 設定各學制特有欄位
        if ($system_id == 1) {
            if ($request->input('action') == 'commit') {
                // 送出需要驗證所有欄位
                $validationRules += [
                    'admission_placement_quota' => 'required|integer', //聯合分發名額（只有學士班有聯合分發）
                    'decrease_reason_of_admission_placement' =>
                        'if_decrease_reason_required:id,admission_placement_quota|string', //聯合分發人數減招原因（只有學士班有聯合分發）
                    'has_self_enrollment' => 'required|boolean', //是否有自招
                    'has_special_class' => 'required_if:has_self_enrollment,1|boolean', //是否招收僑生專班（二技的很複雜）
                ];
            } else {
                // 儲存不驗證欄位是否為空值
                $validationRules += [
                    'admission_placement_quota' => 'required|nullable|integer', //聯合分發名額（只有學士班有聯合分發）
                    'decrease_reason_of_admission_placement' =>
                        'if_decrease_reason_required:id,admission_placement_quota|nullable|string', //聯合分發人數減招原因（只有學士班有聯合分發）
                    'has_self_enrollment' => 'required|boolean', //是否有自招
                    'has_special_class' => 'required_if:has_self_enrollment,1|boolean', //是否招收僑生專班（二技的很複雜）
                ];
            }

        } else if ($system_id == 2) {
            if ($request->input('action') == 'commit') {
                // 送出需要驗證所有欄位
                $validationRules += [
                    'has_self_enrollment' => 'required|boolean', //是否有自招
                    'has_RiJian' => 'required_if:has_self_enrollment,1|boolean', //是否有招收日間二技學制（二技專用）
                    'has_special_class' => 'required_if:has_self_enrollment,1|boolean', //是否招收僑生專班（二技的很複雜）
                    'self_enrollment_quota' => 'required_if:has_self_enrollment,1|integer', //單獨招收名額（學士班不調查）
                    'approval_no_of_special_class' => 'required_if:has_special_class,1|string', //招收僑生專班文號（二技專用）
                    'approval_doc_of_special_class' => 'required|nullable|file', //招收僑生專班文件電子檔（二技專用）沒給則沿用舊檔案
                ];
            } else {
                // 儲存不驗證欄位是否為空值
                $validationRules += [
                    'has_self_enrollment' => 'required|boolean', //是否有自招
                    'has_RiJian' => 'required_if:has_self_enrollment,1|boolean', //是否有招收日間二技學制（二技專用）
                    'has_special_class' => 'required_if:has_self_enrollment,1|boolean', //是否招收僑生專班（二技的很複雜）
                    'self_enrollment_quota' => 'required_if:has_self_enrollment,1|nullable|integer', //單獨招收名額（學士班不調查）
                    'approval_no_of_special_class' => 'required_if:has_special_class,1|nullable|string', //招收僑生專班文號（二技專用）
                    'approval_doc_of_special_class' => 'required|nullable|file', //招收僑生專班文件電子檔（二技專用）沒給則沿用舊檔案
                ];
            }

        } else if ($system_id == 3 || $system_id == 4)  {
            if ($request->input('action') == 'commit') {
                // 送出需要驗證所有欄位
                $validationRules += [
                    'has_self_enrollment' => 'required|boolean', //是否有自招
                    'has_special_class' => 'required_if:has_self_enrollment,1|boolean', //是否招收僑生專班（二技的很複雜）
                    'self_enrollment_quota' => 'required_if:has_self_enrollment,1|integer', //單獨招收名額（學士班不調查）
                ];
            } else {
                // 儲存不驗證欄位是否為空值
                $validationRules += [
                    'has_self_enrollment' => 'required|boolean', //是否有自招
                    'has_special_class' => 'required_if:has_self_enrollment,1|boolean', //是否招收僑生專班（二技的很複雜）
                    'self_enrollment_quota' => 'required_if:has_self_enrollment,1|nullable|integer', //單獨招收名額（學士班不調查）
                ];
            }
        }

        // 驗證輸入資料
        $validator = Validator::make($request->all(), $validationRules);

        // 輸入資料驗證沒過
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(compact('messages'), 400);
        }

        // 取得該校的 has_enrollment
        $school_history_data = SchoolHistoryData::select('has_self_enrollment')
            ->where('id', '=', $school_id)
            ->latest()
            ->first();
        $school_has_enrollment = $school_history_data->has_self_enrollment;

        // 所有學制：校有自招，系才能自招
        if (!$school_has_enrollment && $request->input('has_self_enrollment')) {
            $messages = array('校有自招，系才能自招');
            return response()->json(compact('messages'), 400);
        }

        // 學碩博特殊限制
        if ($system_id == 1 || $system_id == 3 || $system_id == 4) {
            // 系有自招，才能開專班
            if (!$request->input('has_self_enrollment') && $request->input('has_special_class') ) {
                $messages = array('系有自招，才能開專班');
                return response()->json(compact('messages'), 400);
            }
        }

        // 二技特殊限制
        if ($system_id == 2) {
            // 沒日間，沒專班：不可聯招不可自招
            if (!has_RiJian && !has_special_class) {
                if ($request->input('has_self_enrollment') || $request->input('admission_selection_quota')) {
                    $messages = array('沒日間，沒專班：不可聯招不可自招');
                    return response()->json(compact('messages'), 400);
                }
            }

            // 沒日間，有專班：可聯招不可自招
            if (!has_RiJian && has_special_class) {
                if ($request->input('has_self_enrollment')) {
                    $messages = array('沒日間，有專班：可聯招不可自招');
                    return response()->json(compact('messages'), 400);
                }
            }
        }

        // 整理輸入資料
        $insertData = [
            'info_status' => $status,
            'created_by' => $user->username,
            'ip_address' => $request->ip(),
            // 不可修改的資料承襲上次版本內容
            'school_code' => $historyData->school_code,
            'id' => $historyData->id,
            'title' => $historyData->title,
            'eng_title' => $historyData->eng_title,
            'rank' => $historyData->rank,
            'card_code' => $historyData->action,
            'special_dept_type' => $historyData->special_dept_type,
            'last_year_admission_placement_amount' => $historyData->last_year_admission_placement_amount,
            'last_year_personal_apply_amount' => $historyData->last_year_personal_apply_amount,
            'last_year_personal_apply_offer' => $historyData->last_year_personal_apply_offer,
            // 可修改的資料
            'action' => $request->input('action'),
            'sort_order' => $request->input('sort_order'),
            'memo' => $request->input('memo'),
            'url' => $request->input('url'),
            'eng_url' => $request->input('eng_url'),
            'gender_limit' => $request->input('gender_limit'),
            'description' => $request->input('description'),
            'eng_description' => $request->input('eng_description'),
            'has_foreign_special_class' => $request->input('has_foreign_special_class'),
            'has_eng_taught' => $request->input('has_eng_taught'),
            'has_disabilities' => $request->input('has_disabilities'),
            'has_BuHweiHwaWen' => $request->input('has_BuHweiHwaWen'),
            'has_birth_limit' => $request->input('has_birth_limit'),
            'birth_limit_after' => $request ->input('birth_limit_after'),
            'birth_limit_before' => $request->input('birth_limit_before'),
            'has_review_fee' => $request->input('has_review_fee'),
            'review_fee_detail' => $request->input('review_fee_detail'),
            'eng_review_fee_detail' => $request->input('eng_review_fee_detail'),
            'main_group' => $request->input('main_group'),
            'sub_group' => $request->input('sub_group'),
            'evaluation' => $request->input('evaluation'),
            'admission_selection_quota' => $request->input('admission_selection_quota', 0),
        ];

        // 各學制特別資料整理
        if ($system_id == 1) {
            $insertData += [
                'last_year_admission_placement_quota' => $historyData->last_year_admission_placement_quota,
            ];

            // 若名額資訊未被鎖定，則寫入相關資料；否則資料沿用最新歷史資料
            if (!$this->isLockedCollection->contains($historyQuotaStatus)) {
                $insertData += [
                    'quota_status' => $status,
                    'admission_placement_quota' => $request->input('admission_placement_quota', 0),
                    'decrease_reason_of_admission_placement' => $request->input('decrease_reason_of_admission_placement'),
                    'has_self_enrollment' => $request->input('has_self_enrollment'),
                    'has_special_class' => $request->input('has_special_class'),
                ];
            } else {
                $insertData += [
                    'quota_status' => $historyQuotaStatus,
                    'admission_placement_quota' => $historyData->admission_placement_quota,
                    'decrease_reason_of_admission_placement' => $historyData->decrease_reason_of_admission_placement ,
                    'has_self_enrollment' => $historyData->has_self_enrollment,
                    'has_special_class' => $historyData->has_special_class,
                ];
            }
        } else if ($system_id == 2) {
            // 若名額資訊未被鎖定，則寫入相關資料；否則資料沿用最新歷史資料
            if (!$this->isLockedCollection->contains($historyQuotaStatus)) {
                $insertData += [
                    'quota_status' => $status,
                    'has_self_enrollment' => $request->input('has_self_enrollment'),
                    'has_RiJian' => $request->input('has_RiJian'),
                    'has_special_class' => $request->input('has_special_class'),
                    'self_enrollment_quota' => $request->input('self_enrollment_quota', 0),
                    'approval_no_of_special_class' => $request->input('approval_no_of_special_class'),
                    'approval_doc_of_special_class' => $request->input('approval_doc_of_special_class', $historyData->approval_doc_of_special_class),
                ];
            } else {
                $insertData += [
                    'quota_status' => $historyQuotaStatus,
                    'has_self_enrollment' => $historyData->has_self_enrollment,
                    'has_RiJian' => $historyData->has_RiJian,
                    'has_special_class' => $historyData->has_special_class,
                    'self_enrollment_quota' => $historyData->self_enrollment_quota,
                    'approval_no_of_special_class' => $historyData->approval_no_of_special_class,
                    'approval_doc_of_special_class' => $historyData->approval_doc_of_special_class,
                ];
            }
        } else if ($system_id == 3 || $system_id == 4) {
            $insertData += [
                'system_id' => $system_id
            ];
            // 若名額資訊未被鎖定，則寫入相關資料；否則資料沿用最新歷史資料
            if (!$this->isLockedCollection->contains($historyQuotaStatus)) {
                $insertData += [
                    'quota_status' => $status,
                    'has_self_enrollment' => $request->input('has_self_enrollment'),
                    'has_special_class' => $request->input('has_special_class'),
                ];
            } else {
                $insertData += [
                    'quota_status' => $historyQuotaStatus,
                    'has_self_enrollment' => $historyData->has_self_enrollment,
                    'has_special_class' => $historyData->has_special_class,
                ];
            }
        }

        // 寫入資料
        $resultData = $Model::create($insertData);

        // 依照要求拿取系所資料
        return response()->json($this->getData($system_id, $department_id), 201);
    }

    /**
     * @param $system_id
     * @param $id
     * @return mixed
     */
    public function getData($system_id, $id)
    {
        // 依學制設定系所資料模型
        if ($system_id == 1) {
            $DepartmentHistoryDataModel = new DepartmentHistoryData();
        } else if ($system_id == 2) {
            $DepartmentHistoryDataModel = new TwoYearTechHistoryDepartmentData();
        } else {
            $DepartmentHistoryDataModel = new GraduateDepartmentHistoryData();
        }

        // 依學制取得系所資料
        if ($system_id == 3 || $system_id == 4) {
            // 碩博同表，需多加規則
            $data = $DepartmentHistoryDataModel::select()
                ->where('id', '=', $id)
                ->where('system_id', '=', $system_id)
                ->with('creator.school_editor', 'reviewer.admin')
                ->latest()
                ->first();
        } else {
            // 學士二技各自有表
            $data = $DepartmentHistoryDataModel::select()
                ->where('id', '=', $id)
                ->with('creator.school_editor', 'reviewer.admin')
                ->latest()
                ->first();
        }

        // TODO 缺 `application_docs` 欄位（需是一個 ApplicationDocument array）

        // 取得最新 review data
        if ($data->info_status == 'editing' || $data->info_status == 'returned') {
            $lastReturnedData = $DepartmentHistoryDataModel::where('id', '=', $id)
                ->where('info_status', '=', 'returned')
                ->with('creator.school_editor', 'reviewer.admin')
                ->latest()
                ->first();
        } else {
            $lastReturnedData = NULL;
        }

        $data->last_returned_data = $lastReturnedData;

        return $data;
    }
}
