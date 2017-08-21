<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

use App\SchoolHistoryData;

class ENGSchoolHistoryDataController extends Controller
{
    /** @var SchoolHistoryData */
    private $SchoolHistoryDataModel;

    /**
     * SchoolHistoryDataController constructor.
     *
     * @param SchoolHistoryData $SchoolHistoryDataModel
     */
    public function __construct(SchoolHistoryData $SchoolHistoryDataModel)
    {
        $this->middleware(['auth', 'switch']);

        $this->SchoolHistoryDataModel = $SchoolHistoryDataModel;
    }

    /**
     * @param Request $request
     * @param $school_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $school_id)
    {
        $user = Auth::user();

        // 接受 me 參數
        if ($school_id == 'me') {
            $school_id = $user->school_editor->school_code;
        }

        // 確認使用者權限
        if ($user->can('create', [SchoolHistoryData::class, $school_id])) {
            $history_data = $this->get_data($school_id);

            $v_item = [
                'eng_address' => 'required|string|max:191', //學校英文地址
                'eng_organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位英文名稱
                'eng_url' => 'required|url', //學校英文網站網址
            ];

            if ((bool)$history_data->has_dorm) {
                $v_item += [
                    'eng_dorm_info' => 'required|string', //宿舍英文說明
                ];
            }

            if ((bool)$history_data->has_scholarship) {
                $v_item += [
                    'eng_scholarship_url' => 'required|url', //僑生專屬獎學金英文說明網址
                    'eng_scholarship_dept' => 'required|string', //獎學金負責單位英文名稱
                ];
            }

            // 驗證輸入資料
            $validator = Validator::make($request->all(), $v_item);

            // 驗證沒過
            if ($validator->fails()) {
                $messages = $validator->errors()->all();
                return response()->json(compact('messages'), 400);
            }

            // 整理輸入資料
            $insert_data = [
                'id' => $school_id,
                'created_by' => Auth::id(),
                'ip_address' => $request->ip(),
                // 不可修改資料承襲上次版本內容
                'title' => $history_data->title,
                'eng_title' => $history_data->eng_title,
                'type' => $history_data->type,
                'sort_order' => $history_data->sort_order,
                // 基本資料
                'address' => $history_data->address,
                'eng_address' => $request->input('eng_address'),
                'organization' => $history_data->organization,
                'eng_organization' => $request->input('eng_organization'),
                'has_dorm' => $history_data->has_dorm,
                'url' => $history_data->url,
                'eng_url' => $request->input('eng_url'),
                'phone' => $history_data->phone,
                'fax' => $history_data->fax,
                'has_scholarship' => $history_data->has_scholarship,
                'has_five_year_student_allowed' => $history_data->has_five_year_student_allowed,
                'rule_of_five_year_student' => $history_data->rule_of_five_year_student,
                'rule_doc_of_five_year_student' => $history_data->rule_doc_of_five_year_student,
                'has_self_enrollment' => $history_data->has_self_enrollment,
                'approval_no_of_self_enrollment' => $history_data->approval_no_of_self_enrollment,
                'approval_doc_of_self_enrollment' => $history_data->approval_doc_of_self_enrollment,
            ];

            // 整理住宿資料
            if ((bool)$history_data->has_dorm) {
                $insert_data += [
                    'dorm_info' => $history_data->dorm_info,
                    'eng_dorm_info' => $request->input('eng_dorm_info'),
                ];
            }

            // 整理獎學金資料
            if ((bool)$history_data->has_scholarship) {
                $insert_data += [
                    'scholarship_url' => $history_data->scholarship_url,
                    'eng_scholarship_url' => $request->input('eng_scholarship_url'),
                    'scholarship_dept' => $history_data->scholarship_dept,
                    'eng_scholarship_dept' => $request->input('eng_scholarship_dept'),
                ];
            }

            // 寫入資料
            $new_data = $this->SchoolHistoryDataModel->create($insert_data);

            $new_data = $this->get_data($school_id, $new_data->history_id);

            return response()->json($new_data, 201);
        } else {
            $messages = ['User don\'t have permission to access'];

            return response()->json(compact('messages'), 403);
        }
    }

    /**
     * @param $school_id
     * @param string $history_id
     *
     * @return SchoolHistoryData
     */
    public function get_data($school_id, $history_id = 'latest')
    {
        $data = $this->SchoolHistoryDataModel->where('id', '=', $school_id)
            ->with('creator.school_editor');

        // 容許 latest 字眼（取最新一筆）
        if ($history_id == 'latest') {
            $data = $data->latest()->first();
        } else {
            $data = $data->where('history_id', '=', $history_id)->first();
        }

        return $data;
    }
}