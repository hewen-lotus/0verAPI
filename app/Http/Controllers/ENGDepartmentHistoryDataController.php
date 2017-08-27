<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use DB;
use Auth;
use Validator;

use App\SchoolHistoryData;
use App\DepartmentHistoryData;
use App\DepartmentHistoryApplicationDocument;
use App\TwoYearTechHistoryDepartmentData;
use App\TwoYearTechDepartmentHistoryApplicationDocument;
use App\GraduateDepartmentHistoryData;
use App\GraduateDepartmentHistoryApplicationDocument;
use App\ApplicationDocumentType;
use App\PaperApplicationDocumentHistoryAddress;

class ENGDepartmentHistoryDataController extends Controller
{
    /** @collect system_id_collection */
    private $system_id_collection;

    /** @var PaperApplicationDocumentHistoryAddress */
    private $PaperApplicationDocumentHistoryAddressModel;

    /** @var SchoolHistoryData */
    private $SchoolHistoryDataModel;

    /** @var ApplicationDocumentType */
    private $ApplicationDocumentTypeModel;

    /** @var DepartmentHistoryData */
    private $DepartmentHistoryDataModel;

    /** @var TwoYearTechHistoryDepartmentData */
    private $TwoYearTechHistoryDepartmentDataModel;

    /** @var GraduateDepartmentHistoryData */
    private $GraduateDepartmentHistoryDataModel;

    /**
     * DepartmentHistoryDataController constructor.
     *
     * @param PaperApplicationDocumentHistoryAddress $PaperApplicationDocumentHistoryAddressModel
     * @param SchoolHistoryData $SchoolHistoryDataModel
     * @param ApplicationDocumentType $ApplicationDocumentTypeModel
     * @param DepartmentHistoryData $DepartmentHistoryDataModel
     * @param TwoYearTechHistoryDepartmentData $TwoYearTechHistoryDepartmentDataModel
     * @param GraduateDepartmentHistoryData $GraduateDepartmentHistoryDataModel
     */
    public function __construct(PaperApplicationDocumentHistoryAddress $PaperApplicationDocumentHistoryAddressModel,
                                SchoolHistoryData $SchoolHistoryDataModel,
                                ApplicationDocumentType $ApplicationDocumentTypeModel,
                                DepartmentHistoryData $DepartmentHistoryDataModel,
                                TwoYearTechHistoryDepartmentData $TwoYearTechHistoryDepartmentDataModel,
                                GraduateDepartmentHistoryData $GraduateDepartmentHistoryDataModel)
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

        $this->PaperApplicationDocumentHistoryAddressModel = $PaperApplicationDocumentHistoryAddressModel;

        $this->SchoolHistoryDataModel = $SchoolHistoryDataModel;

        $this->ApplicationDocumentTypeModel = $ApplicationDocumentTypeModel;

        $this->DepartmentHistoryDataModel = $DepartmentHistoryDataModel;

        $this->TwoYearTechHistoryDepartmentDataModel = $TwoYearTechHistoryDepartmentDataModel;

        $this->GraduateDepartmentHistoryDataModel = $GraduateDepartmentHistoryDataModel;
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
            $DepartmentHistoryDataModel = $this->DepartmentHistoryDataModel;
        } else if ($system_id == 2) {
            $DepartmentHistoryDataModel = $this->TwoYearTechHistoryDepartmentDataModel;
        } else {
            $DepartmentHistoryDataModel = $this->GraduateDepartmentHistoryDataModel;
        }

        // 依學制驗證權限
        if (!$user->can('create', [$DepartmentHistoryDataModel, $school_id, $department_id])) {
            $messages = ['User don\'t have permission to access'];

            return response()->json(compact('messages'), 403);
        }

        // 取得最新歷史版本
        $newest_dept_history_data = $this->get_data($school_id, $system_id, $department_id);

        if ($newest_dept_history_data == NULL) {
            $messages = ['Department history data not found'];

            return response()->json(compact('messages'), 404);
        }

        // 設定資料驗證欄位
        $validation_rules = [
            'eng_description' => 'required|string', //學制英文敘述
            'eng_url' => 'required|url', //學校英文網站網址
        ];

        // 如果有審查費用的話，審查費用英文說明為必填
        if ( (bool)$newest_dept_history_data->has_review_fee ) {
            $validation_rules += [
                'eng_review_fee_detail' => 'required|string' //審查費用英文說明
            ];
        }

        // 如果 admission_selection_quota > 0 的話，審查項目英文敘述為必填
        if ($newest_dept_history_data->admission_selection_quota > 0) {
            if ($system_id == 1) {
                $validation_rules += [
                    'application_docs' => 'required|array|not_modifiable_doc_in_array:' . $system_id . ',' . $department_id . ',history', //審查項目
                    'application_docs.*.type_id' => [
                        'required',
                        'distinct',
                        'integer',
                        Rule::exists('application_document_types', 'id')->where(function ($query) use ($system_id) {
                            $query->where('system_id', $system_id);
                        }),
                        Rule::exists('dept_history_application_docs', 'type_id')->where(function ($query) use ($newest_dept_history_data) {
                            $query->where('history_id', $newest_dept_history_data->history_id);
                        })
                    ],
                    'application_docs.*.eng_description' => 'required|string', //審查項目英文敘述
                ];
            } else if ($system_id == 1) {
                $validation_rules += [
                    'application_docs' => 'required|array|not_modifiable_doc_in_array:' . $system_id . ',' . $department_id . ',history', //審查項目
                    'application_docs.*.type_id' => [
                        'required',
                        'distinct',
                        'integer',
                        Rule::exists('application_document_types', 'id')->where(function ($query) use ($system_id) {
                            $query->where('system_id', $system_id);
                        }),
                        Rule::exists('two_year_tech_dept_history_application_docs', 'type_id')->where(function ($query) use ($newest_dept_history_data) {
                            $query->where('history_id', $newest_dept_history_data->history_id);
                        })
                    ],
                    'application_docs.*.eng_description' => 'required|string', //審查項目英文敘述
                ];
            } else {
                $validation_rules += [
                    'application_docs' => 'required|array|not_modifiable_doc_in_array:' . $system_id . ',' . $department_id . ',history', //審查項目
                    'application_docs.*.type_id' => [
                        'required',
                        'distinct',
                        'integer',
                        Rule::exists('application_document_types', 'id')->where(function ($query) use ($system_id) {
                            $query->where('system_id', $system_id);
                        }),
                        Rule::exists('graduate_dept_history_application_docs', 'type_id')->where(function ($query) use ($newest_dept_history_data) {
                            $query->where('history_id', $newest_dept_history_data->history_id);
                        })
                    ],
                    'application_docs.*.eng_description' => 'required|string', //審查項目英文敘述
                ];
            }
        }

        // 驗證輸入資料
        $validator = Validator::make($request->all(), $validation_rules);

        // 輸入資料驗證沒過
        if ($validator->fails()) {
            $messages = $validator->errors()->all();

            return response()->json(compact('messages'), 400);
        }

        // 整理輸入資料
        $insert_data = [
            'created_by' => $user->username,
            'ip_address' => $request->ip(),
            // 不可修改的資料承襲上次版本內容
            'school_code' => $newest_dept_history_data->school_code,
            'id' => $newest_dept_history_data->id,
            'title' => $newest_dept_history_data->title,
            'eng_title' => $newest_dept_history_data->eng_title,
            'rank' => $newest_dept_history_data->rank,
            'card_code' => $newest_dept_history_data->card_code,
            'special_dept_type' => $newest_dept_history_data->special_dept_type,
            'last_year_admission_placement_amount' => $newest_dept_history_data->last_year_admission_placement_amount,
            'last_year_personal_apply_amount' => $newest_dept_history_data->last_year_personal_apply_amount,
            'last_year_personal_apply_offer' => $newest_dept_history_data->last_year_personal_apply_offer,
            'sort_order' => $newest_dept_history_data->sort_order,
            'memo' => $newest_dept_history_data->memo,
            'url' => $newest_dept_history_data->url,
            'eng_url' => $request->input('eng_url'),
            'gender_limit' => $newest_dept_history_data->gender_limit,
            'description' => $newest_dept_history_data->description,
            'eng_description' => $request->input('eng_description'),
            'has_foreign_special_class' => $newest_dept_history_data->has_foreign_special_class,
            'has_eng_taught' => $newest_dept_history_data->has_eng_taught,
            'has_disabilities' => $newest_dept_history_data->has_disabilities,
            'has_BuHweiHwaWen' => $newest_dept_history_data->has_BuHweiHwaWen,
            'has_birth_limit' => $newest_dept_history_data->has_birth_limit,
            'birth_limit_after' => $newest_dept_history_data->birth_limit_after,
            'birth_limit_before' => $newest_dept_history_data->birth_limit_before,
            'main_group' => $newest_dept_history_data->main_group,
            'sub_group' => $newest_dept_history_data->sub_group,
            'group_code' => $newest_dept_history_data->group_code,
            'evaluation' => $newest_dept_history_data->evaluation,
            'admission_selection_quota' => $newest_dept_history_data->admission_selection_quota,
        ];

        // 個人申請人數為 0，則審查費用資料照舊版本；否則照輸入資料
        if ($request->input('admission_selection_quota') <= 0) {
            $insert_data += [
                'has_review_fee' => $newest_dept_history_data->has_review_fee,
                'review_fee_detail' => $newest_dept_history_data->review_fee_detail,
                'eng_review_fee_detail' => $newest_dept_history_data->eng_review_fee_detail,
            ];
        } else {
            $insert_data += [
                'has_review_fee' => $newest_dept_history_data->has_review_fee,
                'review_fee_detail' => $newest_dept_history_data->review_fee_detail,
                'eng_review_fee_detail' => $request->input('eng_review_fee_detail'),
            ];
        }

        // 各學制特別資料整理
        if ($system_id == 1) {
            $insert_data += [
                'last_year_admission_placement_quota' => $newest_dept_history_data->last_year_admission_placement_quota,
                'admission_placement_quota' => $newest_dept_history_data->admission_placement_quota,
                'decrease_reason_of_admission_placement' => $newest_dept_history_data->decrease_reason_of_admission_placement,
                'has_self_enrollment' => $newest_dept_history_data->has_self_enrollment,
                'has_special_class' => $newest_dept_history_data->has_special_class,
            ];
        } else if ($system_id == 2) {
            $insert_data += [
                'has_self_enrollment' => $newest_dept_history_data->has_self_enrollment,
                'has_RiJian' => $newest_dept_history_data->has_RiJian,
                'has_special_class' => $newest_dept_history_data->has_special_class,
                'self_enrollment_quota' => $newest_dept_history_data->self_enrollment_quota,
                'approval_no_of_special_class' => $newest_dept_history_data->approval_no_of_special_class,
                'approval_doc_of_special_class' => $newest_dept_history_data->approval_doc_of_special_class,
            ];
        } else if ($system_id == 3 || $system_id == 4) {
            $insert_data += [
                'system_id' => $system_id,
                'has_self_enrollment' => $newest_dept_history_data->has_self_enrollment,
                'has_special_class' => $newest_dept_history_data->has_special_class,
                'self_enrollment_quota' => $newest_dept_history_data->self_enrollment_quota,
            ];
        }

        $new_department_data = DB::transaction(function () use ($DepartmentHistoryDataModel, $insert_data, $system_id, $request, $newest_dept_history_data, $department_id, $user) {
            // 寫入資料
            $new_department_data = $DepartmentHistoryDataModel::create($insert_data);

            // 依學制設定審查項目資料模型
            if ($system_id == 1) {
                $DepartmentHistoryApplicationDocumentModel = DepartmentHistoryApplicationDocument::class;
            } else if ($system_id == 2) {
                $DepartmentHistoryApplicationDocumentModel = TwoYearTechDepartmentHistoryApplicationDocument::class;
            } else if ($system_id == 3) {
                $DepartmentHistoryApplicationDocumentModel = GraduateDepartmentHistoryApplicationDocument::class;
            } else { // $system_id == 4
                $DepartmentHistoryApplicationDocumentModel = GraduateDepartmentHistoryApplicationDocument::class;
            }

            $application_docs = $newest_dept_history_data->application_docs;

            // 軟刪除系所全部的紙本推薦函地址資料
            $this->PaperApplicationDocumentHistoryAddressModel->where('dept_id', '=', $department_id)->delete();

            // 個人申請人數為 0，則審查項目資料直接沿用；否則英文敘述照輸入資料儲存
            if ($newest_dept_history_data->admission_selection_quota > 0) {
                foreach ($application_docs as &$docs) {
                    $eng_description = $docs['eng_description'];

                    foreach ($request->input('application_docs') as &$input) {
                        if ($docs['type_id'] == $input['type_id']) {
                            $eng_description = $input['eng_description'];

                            break;
                        }
                    }

                    $docs_insert_data = [
                        'history_id' => $new_department_data->history_id,
                        'dept_id' => $department_id,
                        'type_id' => $docs['type_id'],
                        'description' => $docs['description'],
                        'eng_description' => $eng_description,
                        'required' => $docs['required'],
                        'modifiable' => $docs['modifiable']
                    ];

                    $DepartmentHistoryApplicationDocumentModel::create($docs_insert_data);

                    // 如果要紙本推薦函再新增一筆新的
                    if ($docs['paper'] != NULL) {
                        $this->PaperApplicationDocumentHistoryAddressModel->create([
                            'dept_id' => $department_id,
                            'type_id' => $docs['paper']['type_id'],
                            'address' => $docs['paper']['address'],
                            'recipient' => $docs['paper']['recipient'],
                            'phone' => $docs['paper']['phone'],
                            'email' => $docs['paper']['email'],
                            'deadline' => $docs['paper']['deadline'],
                            'created_by' => $user->username
                        ]);
                    }
                }
            } else {
                foreach ($application_docs as &$docs) {
                    $docs_insert_data = [
                        'history_id' => $new_department_data->history_id,
                        'dept_id' => $department_id,
                        'type_id' => $docs['type_id'],
                        'description' => $docs['description'],
                        'eng_description' => $docs['eng_description'],
                        'required' => $docs['required'],
                        'modifiable' => $docs['modifiable']
                    ];

                    $DepartmentHistoryApplicationDocumentModel::create($docs_insert_data);

                    // 如果要紙本推薦函再新增一筆新的
                    if ($docs['paper'] != NULL) {
                        $this->PaperApplicationDocumentHistoryAddressModel->create([
                            'dept_id' => $department_id,
                            'type_id' => $docs['paper']['type_id'],
                            'address' => $docs['paper']['address'],
                            'recipient' => $docs['paper']['recipient'],
                            'phone' => $docs['paper']['phone'],
                            'email' => $docs['paper']['email'],
                            'deadline' => $docs['paper']['deadline'],
                            'created_by' => $user->username
                        ]);
                    }
                }
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
        $school_history_data = $this->SchoolHistoryDataModel->select()
            ->where('id', '=', $school_id)
            ->latest()
            ->first();

        // 依學制設定系所資料模型
        if ($system_id == 1) {
            $DepartmentHistoryDataModel = $this->DepartmentHistoryDataModel;
        } else if ($system_id == 2) {
            $DepartmentHistoryDataModel = $this->TwoYearTechHistoryDepartmentDataModel;
        } else if ($system_id == 3) {
            $DepartmentHistoryDataModel = $this->GraduateDepartmentHistoryDataModel;
        } else { // $system_id == 4
            $DepartmentHistoryDataModel = $this->GraduateDepartmentHistoryDataModel;
        }

        // 依學制取得系所資料
        if ($system_id == 1 || $system_id == 2) {
            // 學士二技各自有表
            $data = $DepartmentHistoryDataModel::select()
                ->where('id', '=', $department_id)
                ->where('school_code', '=', $school_id)
                ->with('creator.school_editor', 'application_docs.type')
                ->with(['application_docs.paper' => function ($query) use ($department_id) {
                    $query->where('dept_id', '=', $department_id);
                }]);
        } else {  // $system_id == 3 || $system_id == 4
            // 碩博同表，需多加規則
            $data = $DepartmentHistoryDataModel::select()
                ->where('id', '=', $department_id)
                ->where('school_code', '=', $school_id)
                ->where('system_id', '=', $system_id)
                ->with('creator.school_editor', 'application_docs.type')
                ->with(['application_docs.paper' => function ($query) use ($department_id) {
                    $query->where('dept_id', '=', $department_id);
                }]);
        }

        // 接受 latest 字串
        if ($history_id == 'latest') {
            $data = $data->latest()->first();
        } else {
            $data = $data->where('history_id', '=', $history_id)->first();
        }

        // 要給校有沒有自招
        $data->school_has_self_enrollment = $school_history_data->has_self_enrollment;

        return $data;
    }
}
