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

    /**
     * 取得學校資訊的歷史版本
     *
     * @param  string $school_id
     * @param  string $histories_id
     * @return \Illuminate\Http\Response
     */
    public function show($school_id, $histories_id)
    {
        $user = Auth::user();

        // 接受 me 參數
        if ($user->school_editor != NULL) {
            if ($school_id == 'me') {
                $school_id = $user->school_editor->school_code;
            }
        }

        if (SchoolHistoryData::where('id', '=', $school_id)->exists()) {
            // 確認使用者權限
            if ($user->can('view', [SchoolHistoryData::class, $school_id, $histories_id])) {
                return $this->getDataById($school_id);
            } else {
                $messages = array('User don\'t have permission to access');

                return response()->json(compact('messages'), 403);
            }
        }

        $messages = array('School Data Not Found!');

        return response()->json(compact('messages'), 404);
    }

    /**
     * 新增學校資料歷史版本
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $school_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $school_id)
    {
        $user = Auth::user();

        // 確認使用者權限
        if ($user->can('create', [SchoolHistoryData::class, $school_id])) {
            // 接受 me 參數
            if ($school_id == 'me') {
                $school_id = $user->school_editor->school_code;
            }

            $historyData = SchoolHistoryData::select()
                ->where('id', '=', $school_id)
                ->latest()
                ->first();

            if ($historyData->info_status == 'waiting' || $historyData->info_status == 'confirmed') {
                $messages = array('Data is locked');

                return response()->json(compact('messages'), 403);
            }

            // 設定資料驗證欄位
            $validator = Validator::make($request->all(), [
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
                'phone' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
                'fax' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
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

            // 分辨動作為儲存還是送出
            if ($request->input('action') == 'commit') {
                $info_status = 'waiting';
            } else {
                $info_status = 'editing';
            }

            // 整理輸入資料
            $insertData = array(
                'id' => $school_id,
                'info_status' => $info_status,
                'created_by' => Auth::id(),
                'ip_address' => $request->ip(),
                // 不可修改資料承襲上次版本內容
                'title' => $historyData->title,
                'eng_title' => $historyData->eng_title,
                'type' => $historyData->type,
                'sort_order' => $historyData->sort_order,
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

            // 整理住宿資料
            if ((bool)$request->input('has_dorm')) {
                $insertData += array(
                    'dorm_info' => $request->input('dorm_info'),
                    'eng_dorm_info' => $request->input('eng_dorm_info'),
                );
            }

            // 整理獎學金資料
            if ((bool)$request->input('has_scholarship')) {
                $insertData += array(
                    'scholarship_url' => $request->input('scholarship_url'),
                    'eng_scholarship_url' => $request->input('eng_scholarship_url'),
                    'scholarship_dept' => $request->input('scholarship_dept'),
                    'eng_scholarship_dept' => $request->input('eng_scholarship_dept'),
                );
            }

            // 整理招收中五生學則資料
            if ((bool)$request->input('has_five_year_student_allowed')) {
                if ($request->file('rule_doc_of_five_year_student')->isValid()) {
                    $extension = $request->rule_doc_of_five_year_student->extension();

                    $five_year_rule_doc_path = $request->file('rule_doc_of_five_year_student')
                        ->storeAs('/', uniqid($request->input('id').'-'.'five_year_rule_doc_').'.'.$extension);
                }

                $insertData += array(
                    'rule_of_five_year_student' => $request->input('rule_of_five_year_student'),
                    'rule_doc_of_five_year_student' => $five_year_rule_doc_path,
                );
            }

            // 整理自招資料
            if ((bool)$request->input('has_self_enrollment')) {
                if ($request->file('approval_doc_of_self_enrollment')->isValid()) {
                    $extension = $request->approval_doc_of_self_enrollment->extension();

                    $self_enrollment_approval_doc_path = $request->file('approval_doc_of_self_enrollment')
                        ->storeAs('/', uniqid($request->input('id').'-self_enrollment_approval_doc_').'.'.$extension);
                }

                $insertData += array(
                    'approval_no_of_self_enrollment' => $request->input('approval_no_of_self_enrollment'),
                    'approval_doc_of_self_enrollment' => $self_enrollment_approval_doc_path,
                );
            }

            // 寫入資料
            $newData = SchoolHistoryData::create($insertData);

            return $this->getDataById($newData->id, 201);
        } else {
            $messages = array('User don\'t have permission to access');

            return response()->json(compact('messages'), 403);
        }
    }

    public function getDataById($id, $status_code = 200)
    {
        $LastSchoolData = SchoolHistoryData::where('id', '=', $id)
            ->with('creator.school_editor', 'reviewer.admin')
            ->latest()
            ->first();

        if ($LastSchoolData->info_status == 'editing' || $LastSchoolData->info_status == 'returned') {
            $LastReturnedSchoolData = SchoolHistoryData::where('id', '=', $id)
                ->where('info_status', '=', 'returned')
                ->with('creator.school_editor', 'reviewer.admin')
                ->latest()
                ->first();
        } else {
            $LastReturnedSchoolData = NULL;
        }

        return response()->json(compact('LastSchoolData', 'LastReturnedSchoolData'), $status_code);
    }
}
