<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

use App\SchoolHistoryData;
use App\SchoolLastYearSelfEnrollmentAndFiveYearStatus;

class SchoolHistoryDataController extends Controller
{
    /** @var SchoolHistoryData */
    private $SchoolHistoryDataModel;

    /** @var SchoolLastYearSelfEnrollmentAndFiveYearStatus */
    private $SchoolLastYearSelfEnrollmentAndFiveYearStatusModel;

    /**
     * SchoolHistoryDataController constructor.
     *
     * @param SchoolHistoryData $SchoolHistoryDataModel
     * @param SchoolLastYearSelfEnrollmentAndFiveYearStatus $SchoolLastYearSelfEnrollmentAndFiveYearStatusModel
     */
    public function __construct(SchoolHistoryData $SchoolHistoryDataModel, SchoolLastYearSelfEnrollmentAndFiveYearStatus $SchoolLastYearSelfEnrollmentAndFiveYearStatusModel)
    {
        $this->middleware(['auth', 'switch']);

        $this->SchoolHistoryDataModel = $SchoolHistoryDataModel;

        $this->SchoolLastYearSelfEnrollmentAndFiveYearStatusModel = $SchoolLastYearSelfEnrollmentAndFiveYearStatusModel;
    }

    /**
     * @param $school_id
     * @param $history_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($school_id, $history_id)
    {
        $user = Auth::user();

        // 接受 me 參數
        if ($user->school_editor != NULL) {
            if ($school_id == 'me') {
                $school_id = $user->school_editor->school_code;
            }
        }

        // 確認使用者權限
        if ($user->can('view', [SchoolHistoryData::class, $school_id, $history_id])) {
            $data = $this->get_data($school_id, $history_id);
            
            if ($data == null) {
                $messages = ['School Data Not Found!'];
                return response()->json(compact('messages'), 404);
            }
            
            return response()->json($data, 200);
        } else {
            $messages = ['User don\'t have permission to access'];
            
            return response()->json(compact('messages'), 403);
        }
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

            // 設定資料驗證欄位
            $validator = Validator::make($request->all(), [
                'address' => 'required|string|max:191', //學校地址
                'eng_address' => 'present|string|max:191', //學校英文地址
                'organization' => 'required|string|max:191', //學校負責僑生事務的承辦單位名稱
                'eng_organization' => 'present|string|max:191', //學校負責僑生事務的承辦單位英文名稱
                'has_dorm' => 'required|boolean', //是否提供宿舍
                'dorm_info' => 'required_if:has_dorm,1|string', //宿舍說明
                'eng_dorm_info' => 'sometimes|nullable|string', //宿舍英文說明
                'url' => 'required|url', //學校網站網址
                'eng_url' => 'present|url', //學校英文網站網址
                'phone' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
                'fax' => 'required|string', //學校聯絡電話（+886-49-2910960#1234）
                'has_scholarship' => 'required|boolean', //是否提供僑生專屬獎學金
                'scholarship_url' => 'required_if:has_scholarship,1|url', //僑生專屬獎學金說明網址
                'eng_scholarship_url' => 'sometimes|nullable|url', //僑生專屬獎學金英文說明網址
                'scholarship_dept' => 'required_if:has_scholarship,1|string', //獎學金負責單位名稱
                'eng_scholarship_dept' => 'sometimes|nullable|string', //獎學金負責單位英文名稱
                'has_five_year_student_allowed' => 'required|boolean', //[中五]我可以招呢
                'rule_of_five_year_student' => 'required_if:has_five_year_student_allowed,1|string', //[中五]給海聯看的學則
                'has_self_enrollment' => 'required|boolean', //[自招]是否單獨招收僑生
                'approval_no_of_self_enrollment' => 'required_if:has_self_enrollment,1|string', //[自招]核定文號
            ]);
            
            // 驗證輸入資料
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
            ];

            // 整理住宿資料
            if ((bool)$request->input('has_dorm')) {
                $insert_data += [
                    'dorm_info' => $request->input('dorm_info'),
                    'eng_dorm_info' => $request->input('eng_dorm_info'),
                ];
            }

            // 整理獎學金資料
            if ((bool)$request->input('has_scholarship')) {
                $insert_data += [
                    'scholarship_url' => $request->input('scholarship_url'),
                    'eng_scholarship_url' => $request->input('eng_scholarship_url'),
                    'scholarship_dept' => $request->input('scholarship_dept'),
                    'eng_scholarship_dept' => $request->input('eng_scholarship_dept'),
                ];
            }

            $school_last_year_self_enrollment_and_five_year_status = $this->SchoolLastYearSelfEnrollmentAndFiveYearStatusModel->find($school_id);

            // 整理招收中五生學則資料
            if ((bool)$request->input('has_five_year_student_allowed')) {
                if ($request->hasFile('rule_doc_of_five_year_student') && $request->file('rule_doc_of_five_year_student')->isValid()) {
                    $extension = $request->rule_doc_of_five_year_student->extension();

                    $five_year_rule_doc_path = $request->file('rule_doc_of_five_year_student')
                        ->storeAs('/', uniqid($history_data->title.'-'.'five_year_rule_doc_').'.'.$extension, 'public');
                } else if ($history_data->rule_doc_of_five_year_student != NULL || (bool)$request->input('has_five_year_student_allowed') == $school_last_year_self_enrollment_and_five_year_status->has_five_year_student_allowed) {
                    $five_year_rule_doc_path = $history_data->rule_doc_of_five_year_student;
                } else {
                    $messages = ['The rule doc of five year student field is required when has five year student allowed is 1.'];

                    return response()->json(compact('messages'), 400);
                }

                $insert_data += [
                    'rule_of_five_year_student' => $request->input('rule_of_five_year_student'),
                    'rule_doc_of_five_year_student' => $five_year_rule_doc_path,
                ];
            }

            // 整理自招資料
            if ((bool)$request->input('has_self_enrollment')) {
                if ($request->hasFile('approval_doc_of_self_enrollment') && $request->file('approval_doc_of_self_enrollment')->isValid()) {
                    $extension = $request->approval_doc_of_self_enrollment->extension();

                    $self_enrollment_approval_doc_path = $request->file('approval_doc_of_self_enrollment')
                        ->storeAs('/', uniqid($history_data->title.'-self_enrollment_approval_doc_').'.'.$extension, 'public');
                } else if ($history_data->approval_doc_of_self_enrollment != NULL || (bool)$request->input('has_self_enrollment') == $school_last_year_self_enrollment_and_five_year_status->has_self_enrollment) {
                    $self_enrollment_approval_doc_path = $history_data->approval_doc_of_self_enrollment;
                } else {
                    $messages = ['The approval doc of self enrollment field is required when has self enrollment is 1.'];

                    return response()->json(compact('messages'), 400);
                }

                $insert_data += [
                    'approval_no_of_self_enrollment' => $request->input('approval_no_of_self_enrollment'),
                    'approval_doc_of_self_enrollment' => $self_enrollment_approval_doc_path,
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
     * @return mixed
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
