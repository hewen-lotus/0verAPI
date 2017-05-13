<?php

namespace App\Http\Controllers;

use App\SchoolReviewer;
use Illuminate\Http\Request;

use Auth;
use Validator;

use App\SchoolData;

class SchoolDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->admin != NULL) {
            return SchoolData::all();
        }

        return SchoolData::where('id', '=', $user->school_editor->school_code)->first();
    }

    /**
     * 新增學校
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|unique:school_data,id', //學校代碼
            'title' => 'required|string|max:191', //學校名稱
            'eng_title' => 'required|string|max:191', //學校英文名稱
            'address' => 'required|string|max:191', //學校地址
            'eng_address' => 'required|string|max:191', //學校英文地址
            'organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位名稱
            'eng_organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位英文名稱
            'dorm_info' => 'required|string', //宿舍說明
            'eng_dorm_info' => 'required|string', //宿舍英文說明
            'url' => 'required|url', //學校網站網址
            'eng_url' => 'required|url', //學校英文網站網址
            'type' => 'required|string|in:國立大學,私立大學,國立科技大學,私立科技大學,僑生先修部', //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
            'phone' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
            'fax' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
            'sort_order' => 'required|integer', //學校顯示排序（教育部給）
            'scholarship' => 'required|boolean', //是否提供僑生專屬獎學金
            'scholarship_url' => 'required_if:scholarship,1|url', //僑生專屬獎學金說明網址
            'eng_scholarship_url' => 'required_if:scholarship,1|url', //僑生專屬獎學金英文說明網址
            'scholarship_dept' => 'required_if:scholarship,1|string', //獎學金負責單位名稱
            'eng_scholarship_dept' => 'required_if:scholarship,1|string', //獎學金負責單位英文名稱
            'five_year_allowed' => 'required|boolean', //[中五]我可以招呢
            'five_year_rule' => 'required_if:five_year_allowed,1|string', //[中五]給海聯看的學則
            'approve_no_of_independent_recruitment' => 'sometimes|nullable|string', //自招核定文號
            'approval_document_of_independent_recruitment' => 'required_if:approve_no_of_independent_recruitment,1|string', //自招核定公文電子檔
            'self_limit' => 'required_if:approve_no_of_independent_recruitment,1|nullable|integer|min:0', //自招總額
        ]);

        if($validator->fails()) {
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
            'dorm_info' => $request->input('dorm_info'),
            'eng_dorm_info' => $request->input('eng_dorm_info'),
            'url' => $request->input('url'),
            'eng_url' => $request->input('eng_url'),
            'type' => $request->input('type'),
            'phone' => $request->input('phone'),
            'fax' => $request->input('fax'),
            'sort_order' => $request->input('sort_order'),
            'scholarship' => $request->input('scholarship'),
            'five_year_prepare' => $request->input('five_year_prepare'),
            'five_year_allowed' => $request->input('five_year_allowed'),
        );

        if ($request->input('scholarship')) {
            $InsertData += array(
                'scholarship_url' => $request->input('scholarship_url'),
                'eng_scholarship_url' => $request->input('eng_scholarship_url'),
                'scholarship_dept' => $request->input('scholarship_dept'),
                'eng_scholarship_dept' => $request->input('eng_scholarship_dept'),
            );
        }

        if ($request->input('five_year_allowed')) {
            $insertData += array(
                'five_year_confirmed_by' => $request->input('five_year_confirmed_by'),
                'five_year_rule' => $request->input('five_year_rule'),
            );
        }

        if ($request->has('approve_no')) {
            $InsertData += array(
                'approve_no' => $request->input('approve_no'),
                'self_limit' => $request->input('self_limit', 0),
            );
        }

        $SchoolData = SchoolData::create($InsertData);

        return response()->json($SchoolData, 201);
    }

    /**
     * 更新學校資訊
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $school_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $school_id)
    {
        if (SchoolData::where('id', '=', $school_id)->exists()) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:191', //學校名稱
                'eng_title' => 'required|string|max:191', //學校英文名稱
                'address' => 'required|string|max:191', //學校地址
                'eng_address' => 'required|string|max:191', //學校英文地址
                'organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位名稱
                'eng_organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位英文名稱
                'dorm_info' => 'required|string', //宿舍說明
                'eng_dorm_info' => 'required|string', //宿舍英文說明
                'url' => 'required|url', //學校網站網址
                'eng_url' => 'required|url', //學校英文網站網址
                'type' => 'required|string|in:國立大學,私立大學,國立科技大學,私立科技大學,僑生先修部', //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
                'phone' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
                'fax' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
                'sort_order' => 'required|integer', //學校顯示排序（教育部給）
                'scholarship' => 'required|boolean', //是否提供僑生專屬獎學金
                'scholarship_url' => 'required_if:scholarship,1|url', //僑生專屬獎學金說明網址
                'eng_scholarship_url' => 'required_if:scholarship,1|url', //僑生專屬獎學金英文說明網址
                'scholarship_dept' => 'required_if:scholarship,1|string', //獎學金負責單位名稱
                'eng_scholarship_dept' => 'required_if:scholarship,1|string', //獎學金負責單位英文名稱
                'five_year_allowed' => 'required|boolean', //[中五]我可以招呢
                'five_year_prepare' => 'required|boolean', //[中五]我準備招了喔
                'five_year_confirmed_by' => 'required_if:five_year_allowed,1|string|exists:school_users,username', //[中五](school_users.username)
                'five_year_rule' => 'required_if:five_year_allowed,1|string', //[中五]給海聯看的學則
                'approve_no' => 'sometimes|required|string', //自招核定文號
                'self_limit' => 'sometimes|required|integer|min:0', //自招總額
            ]);

            if($validator->fails()) {
                $messages = $validator->errors()->all();
                return response()->json(compact('messages'), 400);
            }

            $UpdateData = array(
                'title' => $request->input('title'),
                'eng_title' => $request->input('eng_title'),
                'address' => $request->input('address'),
                'eng_address' => $request->input('eng_address'),
                'organization' => $request->input('organization'),
                'eng_organization' => $request->input('eng_organization'),
                'dorm_info' => $request->input('dorm_info'),
                'eng_dorm_info' => $request->input('eng_dorm_info'),
                'url' => $request->input('url'),
                'eng_url' => $request->input('eng_url'),
                'type' => $request->input('type'),
                'phone' => $request->input('phone'),
                'fax' => $request->input('fax'),
                'sort_order' => $request->input('sort_order'),
                'scholarship' => $request->input('scholarship'),
                'five_year_prepare' => $request->input('five_year_prepare'),
                'five_year_allowed' => $request->input('five_year_allowed'),
            );

            if ($request->input('scholarship')) {
                $UpdateData += array(
                    'scholarship_url' => $request->input('scholarship_url'),
                    'eng_scholarship_url' => $request->input('eng_scholarship_url'),
                    'scholarship_dept' => $request->input('scholarship_dept'),
                    'eng_scholarship_dept' => $request->input('eng_scholarship_dept'),
                );
            } else {
                $UpdateData += array(
                    'scholarship_url' => NULL,
                    'eng_scholarship_url' => NULL,
                    'scholarship_dept' => NULL,
                    'eng_scholarship_dept' => NULL,
                );
            }

            if ($request->input('five_year_allowed')) {
                $UpdateData += array(
                    'five_year_confirmed_by' => $request->input('five_year_confirmed_by'),
                    'five_year_rule' => $request->input('five_year_rule'),
                );
            } else {
                $UpdateData += array(
                    'five_year_confirmed_by' => NULL,
                    'five_year_rule' => NULL,
                );
            }

            if ($request->has('approve_no')) {
                $UpdateData += array(
                    'approve_no' => $request->input('approve_no'),
                    'self_limit' => $request->input('self_limit', 0),
                );
            } else {
                $UpdateData += array(
                    'approve_no' => NULL,
                    'self_limit' => NULL,
                );
            }

            SchoolData::where('id', '=', $school_id)->update($UpdateData);

            return SchoolData::where('id', '=', $school_id)->first();
        }

        $messages = array('School Data Not Found!');

        return response()->json(compact('messages'), 404);
    }

    /**
     * 取得學校資訊（校名、介紹等）與所有系所資訊
     *
     * @param  string $school_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $school_id)
    {
        if (SchoolData::where('id', '=', $school_id)->exists()) {
            return SchoolData::where('id', '=', $school_id)->with('departments')->first();
        }

        $messages = array('School Data Not Found!');

        return response()->json(compact('messages'), 404);
    }
}
