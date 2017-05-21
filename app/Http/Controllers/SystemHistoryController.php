<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;
use DB;

use App\SchoolData;
use App\SystemHistoryData;

class SystemHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

        // 確認使用者權限
        if ($user->school_editor) {
            return $this->getDataForSchoolEditor($user, $request, $school_id, $system_id, $histories_id);
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

        // 確認使用者權限
        if ($user->school_editor) {
            return $this->storeDataForSchoolEditor($user, $request, $school_id, $system_id);
        } else {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }

    }

    public function getDataForSchoolEditor($user, Request $request, $school_id, $system_id, $histories_id)
    {
        // TODO 若最新資料為 editing or returned，review_by, review_at, review_memo 需為最新一筆狀態為 returned 的內容

        $dataType = $request->query('data_type');

        // 確認使用者權限
        if (!$this->authSchoolId($user, $school_id)) {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        } else {
            $school_id = $user->school_editor->school_code;
        }

        // 只有總編可以看名額啦
        if ($dataType == 'quota' && !$user->school_editor->has_admin) {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }

        // 確認使用者使否有要求的歷史版本的存取權限
        if ($histories_id != 'latest') {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }

        // mapping 學制 id
        $system_id = $this->getSystemId($system_id);
        if ($system_id == 0) {
            $messages = array('System not found.');
            return response()->json(compact('messages'), 404);
        }

        // 依要求拿取資料
        if ($dataType == 'quota') {
            $data = $this->getQuotaDataWithDepartments($school_id, $system_id);
        } else {
            $data = $this->getInfoDataWithDepartments($user, $school_id, $system_id);
        }

        // 回傳結果
        if ($data) {
            return response()->json($data, 200);
        } else {
            $messages = array('System Data Not Found!');
            return response()->json(compact('messages'), 404);
        }
    }

    public function getQuotaDataWithDepartments($school_id, $system_id)
    {
        // TODO 要包含所有系所名額資訊

        // 依照要求設定欄位
        $selectColumns = $this->getSelectColumnsByDataType('quota');

        // 依照要求拿取資料
        return $data = SystemHistoryData::select($selectColumns)
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', $system_id)
            ->with('creator.school_editor', 'reviewer.admin')
            ->latest()
            ->first();
    }

    public function getInfoDataWithDepartments($user, $school_id, $system_id)
    {
        // TODO 要包含 $user 擁有權限的系所列表

        // 依照要求設定欄位
        $selectColumns = $this->getSelectColumnsByDataType('info');

        // 依照要求拿取資料
        return $data = SystemHistoryData::select($selectColumns)
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', $system_id)
            ->with('creator.school_editor', 'reviewer.admin')
            ->latest()
            ->first();
    }

    public function storeDataForSchoolEditor($user, Request $request, $school_id, $system_id)
    {
        // 分辨要求為名額或資料
        $queryDataType = $request->query('data_type');

        // 確認使用者權限
        if (!$this->authSchoolId($user, $school_id) || !$user->school_editor->has_admin) {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        } else {
            $school_id = $user->school_editor->school_code;
        }

        // mapping 學制 id
        $system_id = $this->getSystemId($system_id);
        if ($system_id == 0) {
            $messages = array('System not found.');
            return response()->json(compact('messages'), 404);
        }

        // 取得最新歷史版本
        $historyData = SystemHistoryData::select()
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', $system_id)
            ->latest()
            ->first();

        // 分辨要求新增的是名額還是資料
        if ($queryDataType == 'quota') {
            return $this->storeQuotaData($user, $historyData, $request, $school_id, $system_id);
        } else {
            return $this->storeInfoData($user, $historyData, $request, $school_id, $system_id);
        }

    }

    public function storeQuotaData($user, $historyData, Request $request, $school_id, $system_id)
    {
        // TODO 要包含所有系所名額
        // TODO 要檢查名額總量（二技與學士班共用）
        // TODO 要檢查學校有無開放自招
        // TODO 要檢查系所有無開放自招（二技很複雜）
        // TODO 要可以控制系所的自招與否？（二技很複雜）

        $historyInfoStatus = $historyData->quota_status;
        $historyQuotaStatus = $historyData->info_status;

        // 確認歷史版本是否被 lock
        if ($this->isLocked($historyQuotaStatus)) {
            $messages = array('Data is locked');
            return response()->json(compact('messages'), 403);
        }

        // 分辨動作為儲存還是送出
        if ($request->input('action') == 'commit') {
            $quotaStatus = 'waiting';
        } else {
            $quotaStatus = 'editing';
        }

        // 設定資料驗證欄位
        $validationRules = [
            'action' => 'required|string', //動作
            'last_year_surplus_admission_quota' => 'required|integer' // 未招足名額
        ];

        // 整理輸入資料
        $InsertData = array(
            'school_code' => $school_id,
            'type_id' => $system_id,
            'quota_status' => $quotaStatus,
            'created_by' => $user->username,
            'ip_address' => $request->ip(),
            // 不可修改的資料承襲上次版本內容
            'info_status' => $historyData->info_status,
            'last_year_admission_amount' => $historyData->last_year_admission_amount,
            'ratify_expanded_quota' => $historyData->ratify_expanded_quota,
            // 可修改的資料
            'action' => $request->input('action'),
            'last_year_surplus_admission_quota' => $historyData->last_year_surplus_admission_quota
        );

        // 設定資料驗證器
        $validator = Validator::make($request->all(), $validationRules);

        // 驗證輸入資料
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(compact('messages'), 400);
        }

        // 二技班無 `last_year_surplus_admission_quota`（參照學士班）
        if ($system_id != 2) {
            $InsertData += array(
                'last_year_surplus_admission_quota' => $request->input('last_year_surplus_admission_quota')
            );
        }

        // 寫入資料
        $newDataId = DB::transaction(function () use ($insertData) {

            $resultData = SystemHistoryData::create($insertData);

            return $resultData->history_id;
        });

        // 回傳剛建立的資料
        return response()->json($this->getDataById($newDataId, 'quota'), 201);
    }

    public function storeInfoData($user, $historyData, Request $request, $school_id, $system_id)
    {
        // TODO 回傳結果要包含系所檢表 like getInfoDataWithDepartments()

        $historyInfoStatus = $historyData->quota_status;
        $historyQuotaStatus = $historyData->info_status;

        // 確認歷史版本是否被 lock
        if ($this->isLocked($historyInfoStatus)) {
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
            'action' => 'required|string', //動作
            'description' => 'required|string|max:191', //學制敘述
            'eng_description' => 'required|string|max:191' //學制英文敘述
        );

        // 設定資料驗證器
        $validator = Validator::make($request->all(), $validationRules);

        // 驗證輸入資料
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
        $newDataId = DB::transaction(function () use ($insertData) {

            $resultData = SystemHistoryData::create($insertData);

            return $resultData->history_id;
        });

        // 回傳剛建立的資料
        return response()->json($this->getDataById($newDataId, 'info'), 201);
    }

    public function getDataById($id, $dataType)
    {
        // TODO 若最新資料為 editing or returned，review_by, review_at, review_memo 需為最新一筆狀態為 returned 的內容

        // 依照要求設定欄位
        $selectColumns = $this->getSelectColumnsByDataType($dataType);

        // 依照要求拿取資料
        return SystemHistoryData::select($selectColumns)
            ->where('history_id', '=', $id)
            ->with('creator.school_editor', 'reviewer.admin')
            ->first();
    }

    public function getSelectColumnsByDataType($dataType)
    {
        if ($dataType == 'quota') {
            // 名額
            $selectColumns = [
                'school_code', //學校代碼
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
            ];
        } else {
            // 資料
            $selectColumns = [
                'school_code', //學校代碼
                'description', //學制描述
                'eng_description', //'學制描述
                'created_by', //按下送出的人是誰
                'ip_address', //按下送出的人的IP
                'info_status', //waiting|confirmed|editing|returned
                'quota_status', //waiting|confirmed|editing|returned
                'review_memo', //讓學校再次修改的原因
                'review_by', //海聯回覆的人員
                'review_at', //海聯回覆的時間點
            ];
        }

        return $selectColumns;
    }

    /**
     * 驗證使用者有沒有某學校的存取權限
     *
     *
     */
    public function authSchoolId($user, $school_id)
    {
        return $school_id == $user->school_editor->school_code || $school_id == 'me';
    }

    /**
     * mapping 學制 id
     *
     * system_id: 'bachelor' => 1, 'twoYear' => 2, 'master' => 3, 'phd' => 4
     *
     */
    public function getSystemId($system_id)
    {
        // system_id: 'bachelor' => 1, 'twoYear' => 2, 'master' => 3, 'phd' => 4, other => 0
        if ($system_id == 'bachelor' || $system_id == 1) {
            $system_id = 1;
        } else if ($system_id == 'twoYear' || $system_id == 'two-year' || $system_id == 2) {
            $system_id = 2;
        } else if ($system_id == 'master' || $system_id == 3) {
            $system_id = 3;
        } else if ($system_id == 'master' || $system_id == 4) {
            $system_id = 4;
        } else {
            $system_id = 0;
        }

        return $system_id;
    }

    public function isLocked($status)
    {
        return $status == 'waiting' || $status == 'confirmed';
    }

}
