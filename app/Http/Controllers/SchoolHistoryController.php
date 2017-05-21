<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;
use DB;

use App\SchoolData;
use App\SchoolHistoryData;

class SchoolHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * 取得學校資訊的歷史版本
     *
     * @param  string $school_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $school_id, $histories_id)
    {
        $user = Auth::user();

        // 確認使用者權限
        if ($user->school_editor) {
            // 確認使用者使否有要求的學校的存取權限
            if ($school_id != $user->school_editor->school_code && $school_id != 'me') {
                $messages = array('User don\'t have permission to access');
                return response()->json(compact('messages'), 403);
            }

            // 確認使用者使否有要求的歷史版本的存取權限
            if ($histories_id != 'latest') {
                $messages = array('User don\'t have permission to access');
                return response()->json(compact('messages'), 403);
            }

            // 整理資料
            $schoolData = SchoolHistoryData::select()
                ->where('id', '=', $user->school_editor->school_code)
                ->with('creator.user', 'reviewer.user')
                ->latest()
                ->first();

            // 回傳結果
            if ($schoolData) {
                return $schoolData;
            } else {
                $messages = array('School Data Not Found!');
                return response()->json(compact('messages'), 404);
            }
        } else {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }

    }

    /**
     * 新增學校資料歷史版本
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $school_id)
    {
        $user = Auth::user();

        // 確認使用者權限
        if ($user->school_editor) {
            // 確認使用者使否有要求的學校的存取權限
            if ($school_id != $user->school_editor->school_code && $school_id != 'me') {
                $messages = array('User don\'t have permission to access');
                return response()->json(compact('messages'), 403);
            }
        }

        // 取得最新歷史版本
        $schoolData = SchoolHistoryData::select()
            ->where('id', '=', $user->school_editor->school_code)
            ->latest()
            ->first();

        // 確認歷史版本是否被 lock
        if ($schoolData->info_status == 'waiting' || $schoolData->info_status == 'confirmed') {
            $messages = array('Data is locked');
            return response()->json(compact('messages'), 403);
        }

        // 設定資料驗證欄位
        $validator = Validator::make($request->all(), [
            //'id' => 'required|string|unique:school_data,id', //學校代碼[不可改]
            //'title' => 'required|string|max:191', //學校名稱[不可改]
            //'eng_title' => 'required|string|max:191', //學校英文名稱[不可改]
            'action' => 'required|string', //動作
            'address' => 'required|string|max:191', //學校地址
            'eng_address' => 'required|string|max:191', //學校英文地址
            'organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位名稱
            'eng_organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位英文名稱
            'has_dorm' => 'required|boolean', //是否提供宿舍
            'dorm_info' => 'required_if:has_dorm,1|string', //宿舍說明
            'eng_dorm_info' => 'required_if:has_dorm,1|string', //宿舍英文說明
            'url' => 'required|url', //學校網站網址
            'eng_url' => 'required|url', //學校英文網站網址
            //'type' => 'required|string|in:國立大學,私立大學,國立科技大學,私立科技大學,僑生先修部', //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
            'phone' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
            'fax' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
            //'sort_order' => 'required|integer', //學校顯示排序（教育部給）[不可改]
            'has_scholarship' => 'required|boolean', //是否提供僑生專屬獎學金
            'scholarship_url' => 'required_if:scholarship,1|url', //僑生專屬獎學金說明網址
            'eng_scholarship_url' => 'required_if:scholarship,1|url', //僑生專屬獎學金英文說明網址
            'scholarship_dept' => 'required_if:scholarship,1|string', //獎學金負責單位名稱
            'eng_scholarship_dept' => 'required_if:scholarship,1|string', //獎學金負責單位英文名稱
            'has_five_year_student_allowed' => 'required|boolean', //[中五]我可以招呢
            'rule_of_five_year_student' => 'required_if:has_five_year_student_allowed,1|string', //[中五]給海聯看的學則
            'rule_doc_of_five_year_student' => 'required_if:has_five_year_student_allowed,1|file', //[中五]學則文件電子擋(file path)
            'has_self_enrollment' => 'required|boolean', //[自招]是否單獨招收僑生
            'approval_no_of_self_enrollment' => 'required_if:has_self_enrollment,1|string', //[自招]核定文號
            'approval_doc_of_self_enrollment' => 'required_if:has_self_enrollment,1|file', //[自招]核定公文電子檔(file path)
        ]);

        // 驗證輸入資料
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(compact('messages'), 400);
        }

        // 整理輸入資料
        $InsertData = array(
            // 不可修改資料承襲上次版本內容
            'id' => $schoolData->id,
            'title' => $schoolData->title,
            'eng_title' => $schoolData->eng_title,
            'type' => $schoolData->type,
            'sort_order' => $schoolData->sort_order,
            // 基本資料
            'address' => $request->input('address'),
            'eng_address' => $request->input('eng_address'),
            'organization' => $request->input('organization'),
            'eng_organization' => $request->input('eng_organization'),
            'has_dorm' => $request->input('has_dorm'),
            'url' => $request->input('url'),
            'eng_url' => $request->input('eng_url'),
            'phone' => $request->input('phone'),
            'fax' => $request->input('fax'),
            'has_scholarship' => $request->input('has_scholarship'),
            'has_five_year_student_allowed' => $request->input('has_five_year_student_allowed'),
            'has_self_enrollment' => $request->input('has_self_enrollment'),
        );

        // 分辨動作為儲存還是送出
        if ($request->input('action') == 'commit') {
            $info_status = 'waiting';
        } else {
            $info_status = 'editing';
        }

        $InsertData += array(
            // 填寫資料狀態
            'info_status' => $info_status,
        );

        // 整理住宿資料
        if ((bool)$request->input('has_dorm') == true) {
            $InsertData += array(
                'dorm_info' => $request->input('dorm_info'),
                'eng_dorm_info' => $request->input('eng_dorm_info'),
            );
        }

        // 整理獎學金資料
        if ((bool)$request->input('has_scholarship') == true) {
            $InsertData += array(
                'scholarship_url' => $request->input('scholarship_url'),
                'eng_scholarship_url' => $request->input('eng_scholarship_url'),
                'scholarship_dept' => $request->input('scholarship_dept'),
                'eng_scholarship_dept' => $request->input('eng_scholarship_dept'),
            );
        }

        // 整理招收中五生學則資料
        if ((bool)$request->input('has_five_year_student_allowed') == true) {
            if ($request->file('rule_doc_of_five_year_student')->isValid()) {
                $extension = $request->rule_doc_of_five_year_student->extension();

                $five_year_rule_doc_path = $request->file('rule_doc_of_five_year_student')
                    ->storeAs('/', uniqid($request->input('id').'-'.'five_year_rule_doc_').'.'.$extension);
            }

            $InsertData += array(
                'rule_of_five_year_student' => $request->input('rule_of_five_year_student'),
                'rule_doc_of_five_year_student' => $five_year_rule_doc_path,
            );
        }

        // 整理自招資料
        if ((bool)$request->input('has_self_enrollment') == true) {
            if ($request->file('approval_doc_of_self_enrollment')->isValid()) {
                $extension = $request->approval_doc_of_self_enrollment->extension();

                $self_enrollment_approval_doc_path = $request->file('approval_doc_of_self_enrollment')
                    ->storeAs('/', uniqid($request->input('id').'-self_enrollment_approval_doc_').'.'.$extension);
            }

            $InsertData += array(
                'approval_no_of_self_enrollment' => $request->input('approval_no_of_self_enrollment'),
                'approval_doc_of_self_enrollment' => $self_enrollment_approval_doc_path,
            );
        }

        // 寫入資料
        $SavedInsertData = $InsertData + array('created_by' => Auth::id(), 'ip_address' => $request->ip());

        $newDataid = DB::transaction(function () use ($InsertData, $SavedInsertData) {

            // SchoolData::create($InsertData);

            $SchoolHistoryData = SchoolHistoryData::create($SavedInsertData);

            return $SchoolHistoryData->history_id;
        });

        return response()->json(SchoolHistoryData::find($newDataid), 201);
    }

    /**
     * 更新學校版本資訊（Admin review）
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $school_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $school_id)
    {
        if (SchoolData::where('id', '=', $school_id)->exists()) {
            $LastSavedData = SchoolData::where('id', '=', $school_id)
                ->orderBy('history_id', 'desc')->first();

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:191', //學校名稱
                'eng_title' => 'required|string|max:191', //學校英文名稱
                'address' => 'required|string|max:191', //學校地址
                'eng_address' => 'required|string|max:191', //學校英文地址
                'organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位名稱
                'eng_organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位英文名稱
                'has_dorm' => 'required|boolean', //是否提供宿舍
                'dorm_info' => 'required_if:has_dorm,1|string', //宿舍說明
                'eng_dorm_info' => 'required_if:has_dorm,1|string', //宿舍英文說明
                'url' => 'required|url', //學校網站網址
                'eng_url' => 'required|url', //學校英文網站網址
                'type' => 'required|string|in:國立大學,私立大學,國立科技大學,私立科技大學,僑生先修部', //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
                'phone' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
                'fax' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
                'sort_order' => 'required|integer', //學校顯示排序（教育部給）
                'has_scholarship' => 'required|boolean', //是否提供僑生專屬獎學金
                'scholarship_url' => 'required_if:scholarship,1|url', //僑生專屬獎學金說明網址
                'eng_scholarship_url' => 'required_if:scholarship,1|url', //僑生專屬獎學金英文說明網址
                'scholarship_dept' => 'required_if:scholarship,1|string', //獎學金負責單位名稱
                'eng_scholarship_dept' => 'required_if:scholarship,1|string', //獎學金負責單位英文名稱
                'has_five_year_student_allowed' => 'required|boolean', //[中五]我可以招呢
                'rule_of_five_year_student' => 'required_if:has_five_year_student_allowed,1|string', //[中五]給海聯看的學則
                'has_self_enrollment' => 'required|boolean', //[自招]是否單獨招收僑生
                'approve_no_of_self_enrollment' => 'required_if:has_self_enrollment,1|string', //[自招]核定文號
                'modified_by' => Auth::id(),
                'ip_address' => $request->ip(),
            ]);

            if ($validator->fails()) {
                $messages = $validator->errors()->all();
                return response()->json(compact('messages'), 400);
            }

            $InsertData = array(
                'id' => $request->input('id'),
                'title' => $request->input('title'),
                'eng_title' => $request->input('eng_title'),
                'address' => $request->input('address'),
                'eng_address' => $request->input('eng_address'),
                'organization' => $request->input('organization'),
                'eng_organization' => $request->input('eng_organization'),
                'has_dorm' => $request->input('has_dorm'),
                'url' => $request->input('url'),
                'eng_url' => $request->input('eng_url'),
                'type' => $request->input('type'),
                'phone' => $request->input('phone'),
                'fax' => $request->input('fax'),
                'sort_order' => $request->input('sort_order'),
                'has_scholarship' => $request->input('has_scholarship'),
                'has_five_year_student_allowed' => $request->input('has_five_year_student_allowed'),
                'has_self_enrollment' => $request->input('has_self_enrollment'),
                'modified_by' => Auth::id(),
                'ip_address' => $request->ip(),
            );

            if ((bool)$request->input('has_dorm') == true) {
                $InsertData += array(
                    'dorm_info' => $request->input('dorm_info'),
                    'eng_dorm_info' => $request->input('eng_dorm_info'),
                );
            } else {
                $InsertData += array(
                    'dorm_info' => NULL,
                    'eng_dorm_info' => NULL,
                );
            }

            if ((bool)$request->input('has_scholarship') == true) {
                $InsertData += array(
                    'scholarship_url' => $request->input('scholarship_url'),
                    'eng_scholarship_url' => $request->input('eng_scholarship_url'),
                    'scholarship_dept' => $request->input('scholarship_dept'),
                    'eng_scholarship_dept' => $request->input('eng_scholarship_dept'),
                );
            } else {
                $InsertData += array(
                    'scholarship_url' => NULL,
                    'eng_scholarship_url' => NULL,
                    'scholarship_dept' => NULL,
                    'eng_scholarship_dept' => NULL,
                );
            }

            if ((bool)$request->input('has_five_year_student_allowed') == true) {
                if ($request->file('rule_doc_of_five_year_student')->isValid()) {
                    $extension = $request->rule_doc_of_five_year_student->extension();

                    $five_year_rule_doc_path = $request->file('rule_doc_of_five_year_student')
                        ->storeAs('/', uniqid($request->input('id').'-'.'five_year_rule_doc_').'.'.$extension);
                } else {
                    $five_year_rule_doc_path = $LastSavedData->rule_doc_of_five_year_student;
                }

                $InsertData += array(
                    'rule_of_five_year_student' => $request->input('rule_of_five_year_student'),
                    'rule_doc_of_five_year_student' => $five_year_rule_doc_path,
                );
            } else {
                $InsertData += array(
                    'rule_of_five_year_student' => NULL,
                    'rule_doc_of_five_year_student' => NULL,
                );
            }

            if ((bool)$request->input('has_self_enrollment') == true) {
                if ($request->file('approval_doc_of_self_enrollment')->isValid()) {
                    $extension = $request->approval_doc_of_self_enrollment->extension();

                    $self_enrollment_approval_doc_path = $request->file('approval_doc_of_self_enrollment')
                        ->storeAs('/', uniqid($request->input('id').'-self_enrollment_approval_doc_').'.'.$extension);
                } else {
                    $self_enrollment_approval_doc_path = $LastSavedData->approval_doc_of_self_enrollment;
                }

                $InsertData += array(
                    'approve_no_of_self_enrollment' => $request->input('approve_no_of_self_enrollment'),
                    'approval_doc_of_self_enrollment' => $self_enrollment_approval_doc_path,
                );
            } else {
                $InsertData += array(
                    'approve_no_of_self_enrollment' => NULL,
                    'approval_doc_of_self_enrollment' => NULL,
                );
            }

            return response()->json(SchoolSavedData::create($InsertData));
        }

        $messages = array('School Data Not Found!');

        return response()->json(compact('messages'), 404);
    }
}
