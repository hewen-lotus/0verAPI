<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

use App\SystemHistoryData;

class SystemHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->isLockedCollection = collect(['waiting', 'confirmed']);

        $this->system_id = collect([
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
            $system_id = $this->system_id->get($system_id, 0);

            if ($system_id == 0) {
                $messages = array('System history version not found.');
                return response()->json(compact('messages'), 404);
            }

            // TODO 要包含 $user 擁有權限的系所列表

            // 依照要求拿取資料
            $data = SystemHistoryData::select($this->columnsCollection->get('info'))
                ->where('school_code', '=', $school_id)
                ->where('type_id', '=', $system_id)
                ->with('type', 'creator.school_editor', 'reviewer.admin', 'departments', 'graduate_departments', 'two_year_tech_departments')
                ->latest()
                ->first();

            if ($data) {
                return response()->json($data, 200);
            } else {
                $messages = array('System Data Not Found!');
                return response()->json(compact('messages'), 404);
            }
        } else if ($user->can('view_quota', [SystemHistoryData::class, $school_id, $dataType, $histories_id])) {
            $school_id = $user->school_editor->school_code;

            // mapping 學制 id (預設為 0)
            $system_id = $this->system_id->get($system_id, 0);

            if ($system_id == 0) {
                $messages = array('System history version not found.');

                return response()->json(compact('messages'), 404);
            }

            // TODO 要包含所有系所名額資訊

            // 依照要求拿取資料
            $data = SystemHistoryData::select($this->columnsCollection->get('quota'))
                ->where('school_code', '=', $school_id)
                ->where('type_id', '=', $system_id)
                ->with('type', 'creator.school_editor', 'reviewer.admin', 'departments', 'graduate_departments', 'two_year_tech_departments')
                ->latest()
                ->first();

            if ($data) {
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
            $system_id = $this->system_id->get($system_id, 0);

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

            // TODO 回傳結果要包含系所檢表 like getInfoDataWithDepartments()

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
            $resultData = SystemHistoryData::create($insertData);

            // 回傳剛建立的資料
            return response()->json($this->getDataById($resultData->history_id, 'info'), 201);
        } else if ($user->can('create_quota', [SystemHistoryData::class, $school_id, $dataType])) {
            $school_id = $user->school_editor->school_code;

            // mapping 學制 id (預設為 0)
            $system_id = $this->system_id->get($system_id, 0);

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

            // 設定資料驗證欄位
            $validationRules = [
                'action' => 'required|in:save,commit|string', //動作
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
