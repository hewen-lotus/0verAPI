<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use DB;
use Auth;
use Validator;

//use App\SchoolEditor;
use App\SchoolHistoryData;
//use App\SystemHistoryData;
//use App\DepartmentData;
use App\DepartmentHistoryData;
use App\DepartmentHistoryApplicationDocument;
//use App\TwoYearTechDepartmentData;
use App\TwoYearTechHistoryDepartmentData;
use App\TwoYearTechDepartmentHistoryApplicationDocument;
//use App\GraduateDepartmentData;
use App\GraduateDepartmentHistoryData;
use App\GraduateDepartmentHistoryApplicationDocument;

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

        $this->system_id_collection = collect([
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
     * @param $history_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($school_id, $system_id, $department_id, $history_id)
    {
        $user = Auth::user();

        // 接受 me 參數
        if ($user->school_editor != NULL) {
            if ($school_id == 'me') {
                $school_id = $user->school_editor->school_code;
            }
        }

        // mapping 學制 id
        $system_id = $this->system_id_collection->get($system_id, 0);

        // 驗證學制是否存在
        if ($system_id == 0) {
            $messages = ['System not found.'];

            return response()->json(compact('messages'), 404);
        }

        // 依學制設定 Model
        if ($system_id == 1) {
            $DepartmentHistoryDataModel = DepartmentHistoryData::class;
        } else if ($system_id == 2) {
            $DepartmentHistoryDataModel = TwoYearTechHistoryDepartmentData::class;
        } else {
            $DepartmentHistoryDataModel = GraduateDepartmentHistoryData::class;
        }

        // 依學制驗證權限
        if ($user->can('view', [$DepartmentHistoryDataModel, $school_id, $department_id])) {
            // 依照要求拿取系所資料
            $data = $this->get_data($school_id, $system_id, $department_id, $history_id);

            if ($data == NULL) {
                $messages = ['Department history version not found.'];
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
     * @param $system_id
     * @param $department_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $school_id, $system_id, $department_id)
    {
        // TODO 書審項目同一 type 不能重複 -> done by richegg
        // TODO 書審項目要檢查是否為 modifiable，若否則學校不可修改 -> maby done by richegg

        $user = Auth::user();

        // 接受 me 參數
        if ($user->school_editor != NULL) {
            if ($school_id == 'me') {
                $school_id = $user->school_editor->school_code;
            }
        }

        // mapping 學制 id
        $system_id = $this->system_id_collection->get($system_id, 0);

        // 驗證學制是否存在
        if ($system_id == 0) {
            $messages = ['System not found.'];
            
            return response()->json(compact('messages'), 404);
        }

        // 依學制設定 Model
        if ($system_id == 1) {
            $DepartmentHistoryDataModel = DepartmentHistoryData::class;
        } else if ($system_id == 2) {
            $DepartmentHistoryDataModel = TwoYearTechHistoryDepartmentData::class;
        } else {
            $DepartmentHistoryDataModel = GraduateDepartmentHistoryData::class;
        }

        // 依學制驗證權限
        if (!$user->can('create', [$DepartmentHistoryDataModel, $school_id, $department_id])) {
            $messages = ['User don\'t have permission to access'];
            
            return response()->json(compact('messages'), 403);
        }
        
        // 設定資料驗證欄位
        $validation_rules = [
            'sort_order' => 'required|integer', //系所顯示排序
            'description' => 'required|string', //系所敘述
            'eng_description' => 'present|string', //學制英文敘述
            'memo' => 'present|string', //給海聯備註
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
            'application_docs' => 'required|array|unique_array_item|not_modifiable_doc_in_array:'.$system_id.','.$department_id.',history', //審查項目
            'application_docs.*.type' => [
                'required',
                'string',
                Rule::exists('application_document_types', 'id')->where(function ($query) use ($system_id) {
                    $query->where('system_id', $system_id);
                })
            ],
            'application_docs.*.description' => 'required|string', //審查項目敘述
            'application_docs.*.eng_description' => 'present|string', //審查項目英文敘述
            'application_docs.*.required' => 'required|boolean', //審查項目是否為必交
        ];

        // 設定各學制特有欄位
        if ($system_id == 1) {
            $validation_rules += [
                'admission_placement_quota' => 'required|integer', //聯合分發名額（只有學士班有聯合分發）
                'decrease_reason_of_admission_placement' =>
                    'if_decrease_reason_required:id,admission_placement_quota|string', //聯合分發人數減招原因（只有學士班有聯合分發）
                'has_self_enrollment' => 'required|boolean', //是否有自招
                'has_special_class' => 'required_if:has_self_enrollment,1|boolean', //是否招收僑生專班（二技的很複雜）
            ];
        } else if ($system_id == 2) {
            // 送出需要驗證所有欄位
            $validation_rules += [
                'has_self_enrollment' => 'required|boolean', //是否有自招
                'has_RiJian' => 'required_if:has_self_enrollment,1|boolean', //是否有招收日間二技學制（二技專用）
                'has_special_class' => 'required_if:has_self_enrollment,1|boolean', //是否招收僑生專班（二技的很複雜）
                'self_enrollment_quota' => 'required_if:has_self_enrollment,1|integer', //單獨招收名額（學士班不調查）
                'approval_no_of_special_class' => 'required_if:has_special_class,1|string', //招收僑生專班文號（二技專用）
                'approval_doc_of_special_class' => 'required|nullable|file', //招收僑生專班文件電子檔（二技專用）沒給則沿用舊檔案
            ];
        } else if ($system_id == 3 || $system_id == 4)  {
            $validation_rules += [
                'has_self_enrollment' => 'required|boolean', //是否有自招
                'has_special_class' => 'required_if:has_self_enrollment,1|boolean', //是否招收僑生專班（二技的很複雜）
                'self_enrollment_quota' => 'required_if:has_self_enrollment,1|integer', //單獨招收名額（學士班不調查）
            ];
        }

        // 驗證輸入資料
        $validator = Validator::make($request->all(), $validation_rules);

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
            // TODO check variable
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



        $new_department_data = DB::transaction(function () use ($request, $user, $school_id, $system_id, $department_id, $DepartmentHistoryDataModel) {
            // 取得最新歷史版本
            $department_history_data = $this->get_data($school_id, $system_id, $department_id);

            if ($department_history_data == NULL) {
                $messages = ['Department history data not found'];

                return response()->json(compact('messages'), 404);
            }

            // 整理輸入資料
            $insert_data = [
                'created_by' => $user->username,
                'ip_address' => $request->ip(),
                // 不可修改的資料承襲上次版本內容
                'school_code' => $department_history_data->school_code,
                'id' => $department_history_data->id,
                'title' => $department_history_data->title,
                'eng_title' => $department_history_data->eng_title,
                'rank' => $department_history_data->rank,
                'card_code' => $department_history_data->action,
                'special_dept_type' => $department_history_data->special_dept_type,
                'last_year_admission_placement_amount' => $department_history_data->last_year_admission_placement_amount,
                'last_year_personal_apply_amount' => $department_history_data->last_year_personal_apply_amount,
                'last_year_personal_apply_offer' => $department_history_data->last_year_personal_apply_offer,
                // 可修改的資料
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
                $insert_data += [
                    'last_year_admission_placement_quota' => $department_history_data->last_year_admission_placement_quota,
                    'admission_placement_quota' => $request->input('admission_placement_quota', 0),
                    'decrease_reason_of_admission_placement' => $request->input('decrease_reason_of_admission_placement'),
                    'has_self_enrollment' => $request->input('has_self_enrollment'),
                    'has_special_class' => $request->input('has_special_class'),
                ];
            } else if ($system_id == 2) {
                $insert_data += [
                    'quota_status' => $status,
                    'has_self_enrollment' => $request->input('has_self_enrollment'),
                    'has_RiJian' => $request->input('has_RiJian'),
                    'has_special_class' => $request->input('has_special_class'),
                    'self_enrollment_quota' => $request->input('self_enrollment_quota', 0),
                    'approval_no_of_special_class' => $request->input('approval_no_of_special_class'),
                    'approval_doc_of_special_class' => $request->input('approval_doc_of_special_class', $department_history_data->approval_doc_of_special_class),
                ];
            } else if ($system_id == 3 || $system_id == 4) {
                $insert_data += [
                    'system_id' => $system_id,
                    'has_self_enrollment' => $request->input('has_self_enrollment'),
                    'has_special_class' => $request->input('has_special_class'),
                ];
            }

            // 寫入資料
            $new_department_data = $DepartmentHistoryDataModel::create($insert_data);

            // 依學制設定審查項目資料模型
            if ($system_id == 1) {
                $DepartmentHistoryApplicationDocumentModel = DepartmentHistoryApplicationDocument::class;

            } else if ($system_id == 2) {
                $DepartmentHistoryApplicationDocumentModel = TwoYearTechDepartmentHistoryApplicationDocument::class;
            } else if ($system_id == 3 || $system_id == 4) {
                $DepartmentHistoryApplicationDocumentModel = GraduateDepartmentHistoryApplicationDocument::class;
            }

            foreach ($request->input('application_docs') as &$docs) {
                $docs_insert_data = [
                    'history_id' => $new_department_data->history_id,
                    'dept_id' => $department_id,
                    'type_id' => $docs['type'],
                    'description' => $docs['description'],
                    'eng_description' => $docs['eng_description'],
                    'required' => $docs['required'],
                ];

                $new_docs_data = $DepartmentHistoryApplicationDocumentModel::create($docs_insert_data);
            }

            return $new_department_data;
        });

        // 依照要求拿取系所資料
        $new_data = $this->get_data($school_id, $system_id, $department_id, $new_department_data->history_id);

        if ($new_data == NULL) {
            $messages = ['Department history version not found.'];

            return response()->json(compact('messages'), 404);
        }

        return response()->json($new_data, 201);
    }

    /**
     * @param $school_id
     * @param $system_id
     * @param $department_id
     * @param string $history_id
     * @return mixed
     */
    public function get_data($school_id, $system_id, $department_id, $history_id = 'latest')
    {
        // 依學制設定系所資料模型
        if ($system_id == 1) {
            $DepartmentHistoryDataModel = DepartmentHistoryData::class;
        } else if ($system_id == 2) {
            $DepartmentHistoryDataModel = TwoYearTechHistoryDepartmentData::class;
        } else if ($system_id == 3 || $system_id == 4) {
            $DepartmentHistoryDataModel = GraduateDepartmentHistoryData::class;
        }

        // 依學制取得系所資料
        if ($system_id == 1 || $system_id == 2) {
            // 學士二技各自有表
            $data = $DepartmentHistoryDataModel::select()
                ->where('id', '=', $department_id)
                ->where('school_code', '=', $school_id)
                ->with('creator.school_editor', 'application_docs.type');
        } else if ($system_id == 3 || $system_id == 4) {
            // 碩博同表，需多加規則
            $data = $DepartmentHistoryDataModel::select()
                ->where('id', '=', $department_id)
                ->where('school_code', '=', $school_id)
                ->where('system_id', '=', $system_id)
                ->with('creator.school_editor', 'application_docs.type');
        }

        // 接受 latest 字串
        if ($history_id == 'latest') {
            $data = $data->latest()->first();
        } else {
            $data = $data->where('history_id', '=', $history_id)->first();
        }

        return $data;
    }
}
