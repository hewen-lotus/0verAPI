<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SchoolHistoryData;
use App\DepartmentHistoryApplicationDocument;
use App\GraduateDepartmentHistoryApplicationDocument;
use App\TwoYearTechDepartmentHistoryApplicationDocument;
use App\SystemData;
use App\SchoolData;
use App\DepartmentData;
use App\DepartmentApplicationDocument;
use App\TwoYearTechDepartmentData;
use App\TwoYearTechDepartmentApplicationDocument;
use App\GraduateDepartmentData;
use App\GraduateDepartmentApplicationDocument;
use App\PaperApplicationDocumentAddress;

use Carbon\Carbon;
use Auth;
use DB;

class SyncHistoryDataToFormalController extends Controller
{
    /** @var SchoolHistoryData */
    private $SchoolHistoryDataModel;

    /** @var DepartmentHistoryApplicationDocument */
    private $DepartmentHistoryApplicationDocumentModel;

    /** @var GraduateDepartmentHistoryApplicationDocument */
    private $GraduateDepartmentHistoryApplicationDocumentModel;

    /** @var TwoYearTechDepartmentHistoryApplicationDocument */
    private $TwoYearTechDepartmentHistoryApplicationDocumentModel;

    /** @var SystemData */
    private $SystemDataModel;

    /** @var SchoolData */
    private $SchoolDataModel;

    /** @var DepartmentData */
    private $DepartmentDataModel;

    /** @var DepartmentApplicationDocument */
    private $DepartmentApplicationDocumentModel;

    /** @var TwoYearTechDepartmentData */
    private $TwoYearTechDepartmentDataModel;

    /** @var TwoYearTechDepartmentApplicationDocument */
    private $TwoYearTechDepartmentApplicationDocumentModel;

    /** @var GraduateDepartmentData */
    private $GraduateDepartmentDataModel;

    /** @var GraduateDepartmentApplicationDocument */
    private $GraduateDepartmentApplicationDocumentModel;

    /** @var PaperApplicationDocumentAddress */
    private $PaperApplicationDocumentAddressModel;

    /**
     * SyncHistoryDataToFormalController constructor.
     *
     * @param SchoolHistoryData $SchoolHistoryDataModel
     * @param DepartmentHistoryApplicationDocument $DepartmentHistoryApplicationDocumentModel
     * @param GraduateDepartmentHistoryApplicationDocument $GraduateDepartmentHistoryApplicationDocumentModel
     * @param TwoYearTechDepartmentHistoryApplicationDocument $TwoYearTechDepartmentHistoryApplicationDocumentModel
     * @param SystemData $SystemDataModel
     * @param SchoolData $SchoolDataModel
     * @param DepartmentData $DepartmentDataModel
     * @param DepartmentApplicationDocument $DepartmentApplicationDocumentModel
     * @param TwoYearTechDepartmentData $TwoYearTechDepartmentDataModel
     * @param TwoYearTechDepartmentApplicationDocument $TwoYearTechDepartmentApplicationDocumentModel
     * @param GraduateDepartmentData $GraduateDepartmentDataModel
     * @param GraduateDepartmentApplicationDocument $GraduateDepartmentApplicationDocumentModel
     * @param PaperApplicationDocumentAddress $PaperApplicationDocumentAddressModel
     */
    public function __construct(SchoolHistoryData $SchoolHistoryDataModel,
                                DepartmentHistoryApplicationDocument $DepartmentHistoryApplicationDocumentModel,
                                GraduateDepartmentHistoryApplicationDocument $GraduateDepartmentHistoryApplicationDocumentModel,
                                TwoYearTechDepartmentHistoryApplicationDocument $TwoYearTechDepartmentHistoryApplicationDocumentModel,
                                SystemData $SystemDataModel,
                                SchoolData $SchoolDataModel,
                                DepartmentData $DepartmentDataModel,
                                DepartmentApplicationDocument $DepartmentApplicationDocumentModel,
                                TwoYearTechDepartmentData $TwoYearTechDepartmentDataModel,
                                TwoYearTechDepartmentApplicationDocument $TwoYearTechDepartmentApplicationDocumentModel,
                                GraduateDepartmentData $GraduateDepartmentDataModel,
                                GraduateDepartmentApplicationDocument $GraduateDepartmentApplicationDocumentModel,
                                PaperApplicationDocumentAddress $PaperApplicationDocumentAddressModel)
    {
        $this->middleware(['auth', 'switch']);

        $this->SchoolHistoryDataModel = $SchoolHistoryDataModel;

        $this->DepartmentHistoryApplicationDocumentModel = $DepartmentHistoryApplicationDocumentModel;

        $this->GraduateDepartmentHistoryApplicationDocumentModel = $GraduateDepartmentHistoryApplicationDocumentModel;

        $this->TwoYearTechDepartmentHistoryApplicationDocumentModel = $TwoYearTechDepartmentHistoryApplicationDocumentModel;

        $this->SystemDataModel = $SystemDataModel;

        $this->SchoolDataModel = $SchoolDataModel;

        $this->DepartmentDataModel = $DepartmentDataModel;

        $this->DepartmentApplicationDocumentModel = $DepartmentApplicationDocumentModel;

        $this->TwoYearTechDepartmentDataModel = $TwoYearTechDepartmentDataModel;

        $this->TwoYearTechDepartmentApplicationDocumentModel = $TwoYearTechDepartmentApplicationDocumentModel;

        $this->GraduateDepartmentDataModel = $GraduateDepartmentDataModel;

        $this->GraduateDepartmentApplicationDocumentModel = $GraduateDepartmentApplicationDocumentModel;

        $this->PaperApplicationDocumentAddressModel = $PaperApplicationDocumentAddressModel;
    }

    public function bachelor($school_code)
    {
        if ($this->SchoolHistoryDataModel->where('id', '=', $school_code)
            ->whereHas('systems', function ($query) {
                $query->where('type_id', '=', 1);
            })->exists() ) {
            DB::transaction(function () use ($school_code) {
                $school = $this->SchoolHistoryDataModel->where('id', '=', $school_code)->latest()->first();

                $this->SchoolDataModel->updateOrCreate(
                    ['id' => $school->id],
                    [
                        'history_id' => $school->history_id, //從哪一筆歷史紀錄匯入的
                        'updated_by' => Auth::id(), //資料最後更新者
                        'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                        'confirmed_at' => Carbon::now()->toIso8601String(),
                        'title' => $school->title, //學校名稱
                        'eng_title' => $school->eng_title, //學校英文名稱
                        'address' => $school->address, //學校地址
                        'eng_address' => $school->eng_address, //學校英文地址
                        'organization' => $school->organization, //學校負責僑生事務的承辦單位名稱
                        'eng_organization' => $school->eng_organization, //學校負責僑生事務的承辦單位英文名稱
                        'has_dorm' => $school->has_dorm, //是否提供宿舍
                        'dorm_info' => $school->dorm_info, //宿舍說明
                        'eng_dorm_info' => $school->eng_dorm_info, //宿舍英文說明
                        'url' => $school->url, //學校網站網址
                        'eng_url' => $school->eng_url, //學校英文網站網址
                        'type' => $school->type, //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
                        'phone' => $school->phone, //學校聯絡電話（+886-49-2910960#1234）
                        'fax' => $school->fax, //學校聯絡電話（+886-49-2910960#1234）
                        'sort_order' => $school->sort_order, //學校顯示排序（教育部給）
                        'has_scholarship' => $school->has_scholarship, //是否提供僑生專屬獎學金
                        'scholarship_url' => $school->scholarship_url, //僑生專屬獎學金說明網址
                        'eng_scholarship_url' => $school->eng_scholarship_url, //僑生專屬獎學金英文說明網址
                        'scholarship_dept' => $school->scholarship_dept, //獎學金負責單位名稱
                        'eng_scholarship_dept' => $school->eng_scholarship_dept, //獎學金負責單位英文名稱
                        'has_five_year_student_allowed' => $school->has_five_year_student_allowed, //[中五]我可以招呢
                        'rule_of_five_year_student' => $school->rule_of_five_year_student, //[中五]給海聯看的學則
                        'rule_doc_of_five_year_student' => $school->rule_doc_of_five_year_student, //[中五]學則文件電子擋(file path)
                        'has_self_enrollment' => $school->has_self_enrollment, //[自招]是否單獨招收僑生
                        'approval_no_of_self_enrollment' => $school->approval_no_of_self_enrollment, //[自招]核定文號
                        'approval_doc_of_self_enrollment' => $school->approval_doc_of_self_enrollment //[自招]核定公文電子檔(file path)
                    ]
                );

                $system = $school->systems()->where('type_id', '=', 1)->latest()->first();

                $this->SystemDataModel->where('type_id', '=', 1)
                    ->where('school_code', '=', $school_code)
                    ->forceDelete();

                DB::table('system_data')->insert([
                    'type_id' => 1,
                    'school_code' => $school_code,
                    'description' => $system->description, //學制描述
                    'eng_description' => $system->eng_description, //'學制描述
                    'last_year_admission_amount' => $system->last_year_admission_amount, //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
                    'last_year_surplus_admission_quota' => $system->last_year_surplus_admission_quota, //上學年本地生未招足名額（二技參照學士）
                    'ratify_expanded_quota' => $system->ratify_expanded_quota, //本學年教育部核定擴增名額（二技參照學士）
                    'ratify_quota_for_self_enrollment' => $system->ratify_quota_for_self_enrollment, //單獨招收名額（只有學士班有）
                    'history_id' => $system->history_id, //從哪一筆歷史紀錄匯入的
                    'updated_by' => Auth::id(), //資料最後更新者
                    'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                    'confirmed_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String(),
                    'created_at' => Carbon::now()->toIso8601String(),
                ]);

                $depts = DB::table('department_history_data as depts')
                    ->join(DB::raw('(SELECT id, max(history_id) as newest FROM department_history_data group by id) deptid'), function($join) use ($school_code) {
                        $join->on('depts.id', '=', 'deptid.id');
                        $join->on('depts.history_id', '=', 'newest');
                        $join->where('school_code','=', $school_code);
                    })->select('depts.*')->orderBy('sort_order', 'ASC')->get();

                foreach ($depts as $dept) {
                    $this->DepartmentDataModel->updateOrCreate(
                        ['id' => $dept->id, 'school_code' => $school_code],
                        [
                            'history_id' => $dept->history_id, //從哪一筆歷史紀錄匯入的
                            'updated_by' => Auth::id(), //資料最後更新者
                            'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                            'confirmed_at' => Carbon::now()->toIso8601String(),
                            'card_code' => $dept->card_code, //讀卡代碼
                            'title' => $dept->title, //系所名稱
                            'eng_title' => $dept->eng_title, //系所英文名稱
                            'description' => $dept->description, //選系說明
                            'eng_description' => $dept->eng_description, //選系英文說明
                            'memo' => $dept->memo, //給海聯的備註
                            'url' => $dept->url, //系網站網址
                            'eng_url' => $dept->eng_url, //英文系網站網址
                            'last_year_admission_placement_amount' => $dept->last_year_admission_placement_amount, //去年聯合分發錄取名額
                            'last_year_admission_placement_quota' => $dept->last_year_admission_placement_quota, //去年聯合分發名額（只有學士班有聯合分發）
                            'admission_placement_quota' => $dept->admission_placement_quota, //聯合分發名額（只有學士班有聯合分發）
                            'decrease_reason_of_admission_placement' => $dept->decrease_reason_of_admission_placement, //聯合分發人數減招原因
                            'last_year_personal_apply_offer' => $dept->last_year_personal_apply_offer, //去年個人申請錄取名額
                            'last_year_personal_apply_amount' => $dept->last_year_personal_apply_amount, //'去年個人申請名額
                            'admission_selection_quota' => $dept->admission_selection_quota, //個人申請名額
                            'has_self_enrollment' => $dept->has_self_enrollment, //是否有自招
                            'has_special_class' => $dept->has_special_class, //是否招收僑生專班
                            'has_foreign_special_class' => $dept->has_foreign_special_class, //是否招收外生專班
                            'special_dept_type' => $dept->special_dept_type, //特殊系所（醫、牙、中醫、藝術）
                            'gender_limit' => $dept->gender_limit, //性別限制
                            'rank' => $dept->rank, //志願排名
                            'sort_order' => $dept->sort_order, //輸出排序
                            'has_review_fee' => $dept->has_review_fee, //是否另外收取審查費用
                            'review_fee_detail' => $dept->review_fee_detail, //審查費用說明
                            'eng_review_fee_detail' => $dept->eng_review_fee_detail, //審查費用英文說明
                            'has_birth_limit' => $dept->has_birth_limit, //是否限制出生日期
                            'birth_limit_after' => $dept->birth_limit_after, //限…之後出生
                            'birth_limit_before' => $dept->birth_limit_before, //限…之前出生
                            'main_group' => $dept->main_group, //主要隸屬學群代碼
                            'sub_group' => $dept->sub_group, //次要隸屬學群代碼
                            'group_code' => $dept->group_code, //類組
                            'has_eng_taught' => $dept->has_eng_taught, //全英文授課
                            'has_disabilities' => $dept->has_disabilities, //是否招收身障學生
                            'has_BuHweiHwaWen' => $dept->has_BuHweiHwaWen, //是否招收不具華文基礎學生
                            'evaluation' => $dept->evaluation, //系所評鑑等級
                        ]
                    );

                    $this->DepartmentApplicationDocumentModel->where('dept_id', '=', $dept->id)->forceDelete();

                    $this->PaperApplicationDocumentAddressModel->where('dept_id', '=', $dept->id)->forceDelete();

                    if ($dept->admission_selection_quota > 0) {
                        $docs = $this->DepartmentHistoryApplicationDocumentModel->where('dept_id', '=', $dept->id)
                            ->where('history_id', '=', $dept->history_id)->with(['paper' => function ($query) use ($dept) {
                                $query->where('dept_id', '=', $dept->id);
                            }])->get();

                        foreach ($docs as $doc) {
                            DB::table('dept_application_docs')->insert([
                                'dept_id' => $doc->dept_id,
                                'type_id' => $doc->type_id,
                                'description' => $doc->description,
                                'eng_description' => $doc->eng_description, //'學制描述
                                'modifiable' => $doc->modifiable, //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
                                'required' => $doc->required, //上學年本地生未招足名額（二技參照學士）
                                'updated_at' => Carbon::now()->toIso8601String(),
                                'created_at' => Carbon::now()->toIso8601String(),
                            ]);

                            if ($doc->paper != NULL) {
                                DB::table('paper_application_document_address')->insert([
                                    'dept_id' => $doc->dept_id,
                                    'type_id' => $doc->type_id,
                                    'address' => $doc->paper->address,
                                    'recipient' => $doc->paper->recipient,
                                    'phone' => $doc->paper->phone,
                                    'email' => $doc->paper->email,
                                    'deadline' => $doc->paper->deadline,
                                    'updated_at' => Carbon::now()->toIso8601String(),
                                    'created_at' => Carbon::now()->toIso8601String(),
                                ]);
                            }
                        }
                    }
                }
            });

            $messages = ['done！'];

            return response()->json(compact('messages'));
        }

        $messages = ['school_code 或所屬 system_id 不存在！'];

        return response()->json(compact('messages'), 404);
    }

    public function twoyear($school_code)
    {
        if ($this->SchoolHistoryDataModel->where('id', '=', $school_code)
            ->whereHas('systems', function ($query) {
                $query->where('type_id', '=', 2);
            })->exists() ) {
            DB::transaction(function () use ($school_code) {
                $school = $this->SchoolHistoryDataModel->where('id', '=', $school_code)->latest()->first();

                $this->SchoolDataModel->updateOrCreate(
                    ['id' => $school->id],
                    [
                        'history_id' => $school->history_id, //從哪一筆歷史紀錄匯入的
                        'updated_by' => Auth::id(), //資料最後更新者
                        'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                        'confirmed_at' => Carbon::now()->toIso8601String(),
                        'title' => $school->title, //學校名稱
                        'eng_title' => $school->eng_title, //學校英文名稱
                        'address' => $school->address, //學校地址
                        'eng_address' => $school->eng_address, //學校英文地址
                        'organization' => $school->organization, //學校負責僑生事務的承辦單位名稱
                        'eng_organization' => $school->eng_organization, //學校負責僑生事務的承辦單位英文名稱
                        'has_dorm' => $school->has_dorm, //是否提供宿舍
                        'dorm_info' => $school->dorm_info, //宿舍說明
                        'eng_dorm_info' => $school->eng_dorm_info, //宿舍英文說明
                        'url' => $school->url, //學校網站網址
                        'eng_url' => $school->eng_url, //學校英文網站網址
                        'type' => $school->type, //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
                        'phone' => $school->phone, //學校聯絡電話（+886-49-2910960#1234）
                        'fax' => $school->fax, //學校聯絡電話（+886-49-2910960#1234）
                        'sort_order' => $school->sort_order, //學校顯示排序（教育部給）
                        'has_scholarship' => $school->has_scholarship, //是否提供僑生專屬獎學金
                        'scholarship_url' => $school->scholarship_url, //僑生專屬獎學金說明網址
                        'eng_scholarship_url' => $school->eng_scholarship_url, //僑生專屬獎學金英文說明網址
                        'scholarship_dept' => $school->scholarship_dept, //獎學金負責單位名稱
                        'eng_scholarship_dept' => $school->eng_scholarship_dept, //獎學金負責單位英文名稱
                        'has_five_year_student_allowed' => $school->has_five_year_student_allowed, //[中五]我可以招呢
                        'rule_of_five_year_student' => $school->rule_of_five_year_student, //[中五]給海聯看的學則
                        'rule_doc_of_five_year_student' => $school->rule_doc_of_five_year_student, //[中五]學則文件電子擋(file path)
                        'has_self_enrollment' => $school->has_self_enrollment, //[自招]是否單獨招收僑生
                        'approval_no_of_self_enrollment' => $school->approval_no_of_self_enrollment, //[自招]核定文號
                        'approval_doc_of_self_enrollment' => $school->approval_doc_of_self_enrollment //[自招]核定公文電子檔(file path)
                    ]
                );

                $system = $school->systems()->where('type_id', '=', 2)->latest()->first();

                $this->SystemDataModel->where('type_id', '=', 2)
                    ->where('school_code', '=', $school_code)
                    ->forceDelete();

                DB::table('system_data')->insert([
                    'type_id' => 2,
                    'school_code' => $school_code,
                    'description' => $system->description, //學制描述
                    'eng_description' => $system->eng_description, //'學制描述
                    'last_year_admission_amount' => $system->last_year_admission_amount, //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
                    'last_year_surplus_admission_quota' => $system->last_year_surplus_admission_quota, //上學年本地生未招足名額（二技參照學士）
                    'ratify_expanded_quota' => $system->ratify_expanded_quota, //本學年教育部核定擴增名額（二技參照學士）
                    'ratify_quota_for_self_enrollment' => $system->ratify_quota_for_self_enrollment, //單獨招收名額（只有學士班有）
                    'history_id' => $system->history_id, //從哪一筆歷史紀錄匯入的
                    'updated_by' => Auth::id(), //資料最後更新者
                    'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                    'confirmed_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String(),
                    'created_at' => Carbon::now()->toIso8601String(),
                ]);

                $depts = DB::table('two_year_tech_department_history_data as depts')
                    ->join(DB::raw('(SELECT id, max(history_id) as newest FROM two_year_tech_department_history_data group by id) deptid'), function($join) use ($school_code) {
                        $join->on('depts.id', '=', 'deptid.id');
                        $join->on('depts.history_id', '=', 'newest');
                        $join->where('school_code','=', $school_code);
                    })->select('depts.*')->orderBy('sort_order', 'ASC')->get();

                foreach ($depts as $dept) {
                    $this->TwoYearTechDepartmentDataModel->updateOrCreate(
                        ['id' => $dept->id, 'school_code' => $school_code],
                        [
                            'history_id' => $dept->history_id, //從哪一筆歷史紀錄匯入的
                            'updated_by' => Auth::id(), //資料最後更新者
                            'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                            'confirmed_at' => Carbon::now()->toIso8601String(),
                            'title' => $dept->title, //系所名稱
                            'eng_title' => $dept->eng_title, //系所英文名稱
                            'description' => $dept->description, //選系說明
                            'eng_description' => $dept->eng_description, //選系英文說明
                            'memo' => $dept->memo, //給海聯的備註
                            'url' => $dept->url, //系網站網址
                            'eng_url' => $dept->eng_url, //英文系網站網址
                            'last_year_personal_apply_offer' => $dept->last_year_personal_apply_offer, //去年個人申請錄取名額
                            'last_year_personal_apply_amount' => $dept->last_year_personal_apply_amount, //'去年個人申請名額
                            'admission_selection_quota' => $dept->admission_selection_quota, //個人申請名額
                            'has_self_enrollment' => $dept->has_self_enrollment, //是否有自招
                            'self_enrollment_quota' => $dept->self_enrollment_quota, //自招名額
                            'has_RiJian' => $dept->has_RiJian,
                            'has_special_class' => $dept->has_special_class, //是否招收僑生專班
                            'approval_no_of_special_class' => $dept->approval_no_of_special_class, //招收僑生專班核定文號
                            'approval_doc_of_special_class' => $dept->approval_doc_of_special_class, //招收僑生專班核定公文電子檔(file path)
                            'has_foreign_special_class' => $dept->has_foreign_special_class, //是否招收外生專班
                            'special_dept_type' => $dept->special_dept_type, //特殊系所（醫、牙、中醫、藝術）
                            'gender_limit' => $dept->gender_limit, //性別限制
                            'sort_order' => $dept->sort_order, //輸出排序
                            'has_review_fee' => $dept->has_review_fee, //是否另外收取審查費用
                            'review_fee_detail' => $dept->review_fee_detail, //審查費用說明
                            'eng_review_fee_detail' => $dept->eng_review_fee_detail, //審查費用英文說明
                            'has_birth_limit' => $dept->has_birth_limit, //是否限制出生日期
                            'birth_limit_after' => $dept->birth_limit_after, //限…之後出生
                            'birth_limit_before' => $dept->birth_limit_before, //限…之前出生
                            'main_group' => $dept->main_group, //主要隸屬學群代碼
                            'sub_group' => $dept->sub_group, //次要隸屬學群代碼
                            'group_code' => $dept->group_code, //類組
                            'has_eng_taught' => $dept->has_eng_taught, //全英文授課
                            'has_disabilities' => $dept->has_disabilities, //是否招收身障學生
                            'has_BuHweiHwaWen' => $dept->has_BuHweiHwaWen, //是否招收不具華文基礎學生
                            'evaluation' => $dept->evaluation, //系所評鑑等級
                        ]
                    );

                    $this->TwoYearTechDepartmentApplicationDocumentModel->where('dept_id', '=', $dept->id)->forceDelete();

                    $this->PaperApplicationDocumentAddressModel->where('dept_id', '=', $dept->id)->forceDelete();

                    if ($dept->admission_selection_quota > 0) {
                        $docs = $this->TwoYearTechDepartmentHistoryApplicationDocumentModel->where('dept_id', '=', $dept->id)
                            ->where('history_id', '=', $dept->history_id)->with(['paper' => function ($query) use ($dept) {
                                $query->where('dept_id', '=', $dept->id);
                            }])->get();

                        foreach ($docs as $doc) {
                            DB::table('two_year_tech_dept_application_docs')->insert([
                                'dept_id' => $doc->dept_id,
                                'type_id' => $doc->type_id,
                                'description' => $doc->description,
                                'eng_description' => $doc->eng_description, //'學制描述
                                'modifiable' => $doc->modifiable, //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
                                'required' => $doc->required, //上學年本地生未招足名額（二技參照學士）
                                'updated_at' => Carbon::now()->toIso8601String(),
                                'created_at' => Carbon::now()->toIso8601String(),
                            ]);

                            if ($doc->paper != NULL) {
                                DB::table('paper_application_document_address')->insert([
                                    'dept_id' => $doc->dept_id,
                                    'type_id' => $doc->type_id,
                                    'address' => $doc->paper->address,
                                    'recipient' => $doc->paper->recipient,
                                    'phone' => $doc->paper->phone,
                                    'email' => $doc->paper->email,
                                    'deadline' => $doc->paper->deadline,
                                    'updated_at' => Carbon::now()->toIso8601String(),
                                    'created_at' => Carbon::now()->toIso8601String(),
                                ]);
                            }
                        }
                    }
                }
            });

            $messages = ['done！'];

            return response()->json(compact('messages'));
        }

        $messages = ['school_code 或所屬 system_id 不存在！'];

        return response()->json(compact('messages'), 404);
    }

    public function master($school_code)
    {
        if ($this->SchoolHistoryDataModel->where('id', '=', $school_code)
            ->whereHas('systems', function ($query) {
                $query->where('type_id', '=', 3);
            })->exists() ) {
            DB::transaction(function () use ($school_code) {
                $school = $this->SchoolHistoryDataModel->where('id', '=', $school_code)->latest()->first();

                $this->SchoolDataModel->updateOrCreate(
                    ['id' => $school->id],
                    [
                        'history_id' => $school->history_id, //從哪一筆歷史紀錄匯入的
                        'updated_by' => Auth::id(), //資料最後更新者
                        'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                        'confirmed_at' => Carbon::now()->toIso8601String(),
                        'title' => $school->title, //學校名稱
                        'eng_title' => $school->eng_title, //學校英文名稱
                        'address' => $school->address, //學校地址
                        'eng_address' => $school->eng_address, //學校英文地址
                        'organization' => $school->organization, //學校負責僑生事務的承辦單位名稱
                        'eng_organization' => $school->eng_organization, //學校負責僑生事務的承辦單位英文名稱
                        'has_dorm' => $school->has_dorm, //是否提供宿舍
                        'dorm_info' => $school->dorm_info, //宿舍說明
                        'eng_dorm_info' => $school->eng_dorm_info, //宿舍英文說明
                        'url' => $school->url, //學校網站網址
                        'eng_url' => $school->eng_url, //學校英文網站網址
                        'type' => $school->type, //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
                        'phone' => $school->phone, //學校聯絡電話（+886-49-2910960#1234）
                        'fax' => $school->fax, //學校聯絡電話（+886-49-2910960#1234）
                        'sort_order' => $school->sort_order, //學校顯示排序（教育部給）
                        'has_scholarship' => $school->has_scholarship, //是否提供僑生專屬獎學金
                        'scholarship_url' => $school->scholarship_url, //僑生專屬獎學金說明網址
                        'eng_scholarship_url' => $school->eng_scholarship_url, //僑生專屬獎學金英文說明網址
                        'scholarship_dept' => $school->scholarship_dept, //獎學金負責單位名稱
                        'eng_scholarship_dept' => $school->eng_scholarship_dept, //獎學金負責單位英文名稱
                        'has_five_year_student_allowed' => $school->has_five_year_student_allowed, //[中五]我可以招呢
                        'rule_of_five_year_student' => $school->rule_of_five_year_student, //[中五]給海聯看的學則
                        'rule_doc_of_five_year_student' => $school->rule_doc_of_five_year_student, //[中五]學則文件電子擋(file path)
                        'has_self_enrollment' => $school->has_self_enrollment, //[自招]是否單獨招收僑生
                        'approval_no_of_self_enrollment' => $school->approval_no_of_self_enrollment, //[自招]核定文號
                        'approval_doc_of_self_enrollment' => $school->approval_doc_of_self_enrollment //[自招]核定公文電子檔(file path)
                    ]
                );

                $system = $school->systems()->where('type_id', '=', 3)->latest()->first();

                $this->SystemDataModel->where('type_id', '=', 3)
                    ->where('school_code', '=', $school_code)
                    ->forceDelete();

                DB::table('system_data')->insert([
                    'type_id' => 3,
                    'school_code' => $school_code,
                    'description' => $system->description, //學制描述
                    'eng_description' => $system->eng_description, //'學制描述
                    'last_year_admission_amount' => $system->last_year_admission_amount, //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
                    'last_year_surplus_admission_quota' => $system->last_year_surplus_admission_quota, //上學年本地生未招足名額（二技參照學士）
                    'ratify_expanded_quota' => $system->ratify_expanded_quota, //本學年教育部核定擴增名額（二技參照學士）
                    'ratify_quota_for_self_enrollment' => $system->ratify_quota_for_self_enrollment, //單獨招收名額（只有學士班有）
                    'history_id' => $system->history_id, //從哪一筆歷史紀錄匯入的
                    'updated_by' => Auth::id(), //資料最後更新者
                    'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                    'confirmed_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String(),
                    'created_at' => Carbon::now()->toIso8601String(),
                ]);

                $depts = DB::table('graduate_department_history_data as depts')
                    ->join(DB::raw('(SELECT id, max(history_id) as newest FROM graduate_department_history_data group by id) deptid'), function($join) use ($school_code) {
                        $join->on('depts.id', '=', 'deptid.id');
                        $join->on('depts.history_id', '=', 'newest');
                        $join->where('school_code','=', $school_code);
                        $join->where('system_id','=', 3);
                    })->select('depts.*')->orderBy('sort_order', 'ASC')->get();

                foreach ($depts as $dept) {
                    $this->GraduateDepartmentDataModel->updateOrCreate(
                        ['id' => $dept->id, 'school_code' => $school_code],
                        [
                            'history_id' => $dept->history_id, //從哪一筆歷史紀錄匯入的
                            'updated_by' => Auth::id(), //資料最後更新者
                            'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                            'confirmed_at' => Carbon::now()->toIso8601String(),
                            'title' => $dept->title, //系所名稱
                            'eng_title' => $dept->eng_title, //系所英文名稱
                            'system_id' => $dept->system_id, //這是碩士班還是博士班 QQ
                            'description' => $dept->description, //選系說明
                            'eng_description' => $dept->eng_description, //選系英文說明
                            'memo' => $dept->memo, //給海聯的備註
                            'url' => $dept->url, //系網站網址
                            'eng_url' => $dept->eng_url, //英文系網站網址
                            'last_year_personal_apply_offer' => $dept->last_year_personal_apply_offer, //去年個人申請錄取名額
                            'last_year_personal_apply_amount' => $dept->last_year_personal_apply_amount, //'去年個人申請名額
                            'admission_selection_quota' => $dept->admission_selection_quota, //個人申請名額
                            'has_self_enrollment' => $dept->has_self_enrollment, //是否有自招
                            'self_enrollment_quota' => $dept->self_enrollment_quota, //自招名額
                            'has_special_class' => $dept->has_special_class, //是否招收僑生專班
                            'has_foreign_special_class' => $dept->has_foreign_special_class, //是否招收外生專班
                            'special_dept_type' => $dept->special_dept_type, //特殊系所（醫、牙、中醫、藝術）
                            'gender_limit' => $dept->gender_limit, //性別限制
                            'sort_order' => $dept->sort_order, //輸出排序
                            'has_review_fee' => $dept->has_review_fee, //是否另外收取審查費用
                            'review_fee_detail' => $dept->review_fee_detail, //審查費用說明
                            'eng_review_fee_detail' => $dept->eng_review_fee_detail, //審查費用英文說明
                            'has_birth_limit' => $dept->has_birth_limit, //是否限制出生日期
                            'birth_limit_after' => $dept->birth_limit_after, //限…之後出生
                            'birth_limit_before' => $dept->birth_limit_before, //限…之前出生
                            'main_group' => $dept->main_group, //主要隸屬學群代碼
                            'sub_group' => $dept->sub_group, //次要隸屬學群代碼
                            'group_code' => $dept->group_code, //類組
                            'has_eng_taught' => $dept->has_eng_taught, //全英文授課
                            'has_disabilities' => $dept->has_disabilities, //是否招收身障學生
                            'has_BuHweiHwaWen' => $dept->has_BuHweiHwaWen, //是否招收不具華文基礎學生
                            'evaluation' => $dept->evaluation, //系所評鑑等級
                        ]
                    );

                    $this->GraduateDepartmentApplicationDocumentModel->where('dept_id', '=', $dept->id)->forceDelete();

                    $this->PaperApplicationDocumentAddressModel->where('dept_id', '=', $dept->id)->forceDelete();

                    if ($dept->admission_selection_quota > 0) {
                        $docs = $this->GraduateDepartmentHistoryApplicationDocumentModel->where('dept_id', '=', $dept->id)
                            ->where('history_id', '=', $dept->history_id)->with(['paper' => function ($query) use ($dept) {
                                $query->where('dept_id', '=', $dept->id);
                            }])->get();

                        foreach ($docs as $doc) {
                            DB::table('graduate_dept_application_docs')->insert([
                                'dept_id' => $doc->dept_id,
                                'type_id' => $doc->type_id,
                                'description' => $doc->description,
                                'eng_description' => $doc->eng_description, //'學制描述
                                'modifiable' => $doc->modifiable, //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
                                'required' => $doc->required, //上學年本地生未招足名額（二技參照學士）
                                'updated_at' => Carbon::now()->toIso8601String(),
                                'created_at' => Carbon::now()->toIso8601String(),
                            ]);

                            if ($doc->paper != NULL) {
                                DB::table('paper_application_document_address')->insert([
                                    'dept_id' => $doc->dept_id,
                                    'type_id' => $doc->type_id,
                                    'address' => $doc->paper->address,
                                    'recipient' => $doc->paper->recipient,
                                    'phone' => $doc->paper->phone,
                                    'email' => $doc->paper->email,
                                    'deadline' => $doc->paper->deadline,
                                    'updated_at' => Carbon::now()->toIso8601String(),
                                    'created_at' => Carbon::now()->toIso8601String(),
                                ]);
                            }
                        }
                    }
                }
            });

            $messages = ['done！'];

            return response()->json(compact('messages'));
        }

        $messages = ['school_code 或所屬 system_id 不存在！'];

        return response()->json(compact('messages'), 404);
    }

    public function phd($school_code)
    {
        if ($this->SchoolHistoryDataModel->where('id', '=', $school_code)
            ->whereHas('systems', function ($query) {
                $query->where('type_id', '=', 4);
            })->exists() ) {
            DB::transaction(function () use ($school_code) {
                $school = $this->SchoolHistoryDataModel->where('id', '=', $school_code)->latest()->first();

                $this->SchoolDataModel->updateOrCreate(
                    ['id' => $school->id],
                    [
                        'history_id' => $school->history_id, //從哪一筆歷史紀錄匯入的
                        'updated_by' => Auth::id(), //資料最後更新者
                        'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                        'confirmed_at' => Carbon::now()->toIso8601String(),
                        'title' => $school->title, //學校名稱
                        'eng_title' => $school->eng_title, //學校英文名稱
                        'address' => $school->address, //學校地址
                        'eng_address' => $school->eng_address, //學校英文地址
                        'organization' => $school->organization, //學校負責僑生事務的承辦單位名稱
                        'eng_organization' => $school->eng_organization, //學校負責僑生事務的承辦單位英文名稱
                        'has_dorm' => $school->has_dorm, //是否提供宿舍
                        'dorm_info' => $school->dorm_info, //宿舍說明
                        'eng_dorm_info' => $school->eng_dorm_info, //宿舍英文說明
                        'url' => $school->url, //學校網站網址
                        'eng_url' => $school->eng_url, //學校英文網站網址
                        'type' => $school->type, //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
                        'phone' => $school->phone, //學校聯絡電話（+886-49-2910960#1234）
                        'fax' => $school->fax, //學校聯絡電話（+886-49-2910960#1234）
                        'sort_order' => $school->sort_order, //學校顯示排序（教育部給）
                        'has_scholarship' => $school->has_scholarship, //是否提供僑生專屬獎學金
                        'scholarship_url' => $school->scholarship_url, //僑生專屬獎學金說明網址
                        'eng_scholarship_url' => $school->eng_scholarship_url, //僑生專屬獎學金英文說明網址
                        'scholarship_dept' => $school->scholarship_dept, //獎學金負責單位名稱
                        'eng_scholarship_dept' => $school->eng_scholarship_dept, //獎學金負責單位英文名稱
                        'has_five_year_student_allowed' => $school->has_five_year_student_allowed, //[中五]我可以招呢
                        'rule_of_five_year_student' => $school->rule_of_five_year_student, //[中五]給海聯看的學則
                        'rule_doc_of_five_year_student' => $school->rule_doc_of_five_year_student, //[中五]學則文件電子擋(file path)
                        'has_self_enrollment' => $school->has_self_enrollment, //[自招]是否單獨招收僑生
                        'approval_no_of_self_enrollment' => $school->approval_no_of_self_enrollment, //[自招]核定文號
                        'approval_doc_of_self_enrollment' => $school->approval_doc_of_self_enrollment //[自招]核定公文電子檔(file path)
                    ]
                );

                $system = $school->systems()->where('type_id', '=', 4)->latest()->first();

                $this->SystemDataModel->where('type_id', '=', 4)
                    ->where('school_code', '=', $school_code)
                    ->forceDelete();

                DB::table('system_data')->insert([
                    'type_id' => 4,
                    'school_code' => $school_code,
                    'description' => $system->description, //學制描述
                    'eng_description' => $system->eng_description, //'學制描述
                    'last_year_admission_amount' => $system->last_year_admission_amount, //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
                    'last_year_surplus_admission_quota' => $system->last_year_surplus_admission_quota, //上學年本地生未招足名額（二技參照學士）
                    'ratify_expanded_quota' => $system->ratify_expanded_quota, //本學年教育部核定擴增名額（二技參照學士）
                    'ratify_quota_for_self_enrollment' => $system->ratify_quota_for_self_enrollment, //單獨招收名額（只有學士班有）
                    'history_id' => $system->history_id, //從哪一筆歷史紀錄匯入的
                    'updated_by' => Auth::id(), //資料最後更新者
                    'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                    'confirmed_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String(),
                    'created_at' => Carbon::now()->toIso8601String(),
                ]);

                $depts = DB::table('graduate_department_history_data as depts')
                    ->join(DB::raw('(SELECT id, max(history_id) as newest FROM graduate_department_history_data group by id) deptid'), function($join) use ($school_code) {
                        $join->on('depts.id', '=', 'deptid.id');
                        $join->on('depts.history_id', '=', 'newest');
                        $join->where('school_code','=', $school_code);
                        $join->where('system_id','=', 4);
                    })->select('depts.*')->orderBy('sort_order', 'ASC')->get();

                foreach ($depts as $dept) {
                    $this->GraduateDepartmentDataModel->updateOrCreate(
                        ['id' => $dept->id, 'school_code' => $school_code],
                        [
                            'history_id' => $dept->history_id, //從哪一筆歷史紀錄匯入的
                            'updated_by' => Auth::id(), //資料最後更新者
                            'confirmed_by' => Auth::id(), //資料由哪位海聯人員確認匯入的
                            'confirmed_at' => Carbon::now()->toIso8601String(),
                            'title' => $dept->title, //系所名稱
                            'eng_title' => $dept->eng_title, //系所英文名稱
                            'system_id' => $dept->system_id, //這是碩士班還是博士班 QQ
                            'description' => $dept->description, //選系說明
                            'eng_description' => $dept->eng_description, //選系英文說明
                            'memo' => $dept->memo, //給海聯的備註
                            'url' => $dept->url, //系網站網址
                            'eng_url' => $dept->eng_url, //英文系網站網址
                            'last_year_personal_apply_offer' => $dept->last_year_personal_apply_offer, //去年個人申請錄取名額
                            'last_year_personal_apply_amount' => $dept->last_year_personal_apply_amount, //'去年個人申請名額
                            'admission_selection_quota' => $dept->admission_selection_quota, //個人申請名額
                            'has_self_enrollment' => $dept->has_self_enrollment, //是否有自招
                            'self_enrollment_quota' => $dept->self_enrollment_quota, //自招名額
                            'has_special_class' => $dept->has_special_class, //是否招收僑生專班
                            'has_foreign_special_class' => $dept->has_foreign_special_class, //是否招收外生專班
                            'special_dept_type' => $dept->special_dept_type, //特殊系所（醫、牙、中醫、藝術）
                            'gender_limit' => $dept->gender_limit, //性別限制
                            'sort_order' => $dept->sort_order, //輸出排序
                            'has_review_fee' => $dept->has_review_fee, //是否另外收取審查費用
                            'review_fee_detail' => $dept->review_fee_detail, //審查費用說明
                            'eng_review_fee_detail' => $dept->eng_review_fee_detail, //審查費用英文說明
                            'has_birth_limit' => $dept->has_birth_limit, //是否限制出生日期
                            'birth_limit_after' => $dept->birth_limit_after, //限…之後出生
                            'birth_limit_before' => $dept->birth_limit_before, //限…之前出生
                            'main_group' => $dept->main_group, //主要隸屬學群代碼
                            'sub_group' => $dept->sub_group, //次要隸屬學群代碼
                            'group_code' => $dept->group_code, //類組
                            'has_eng_taught' => $dept->has_eng_taught, //全英文授課
                            'has_disabilities' => $dept->has_disabilities, //是否招收身障學生
                            'has_BuHweiHwaWen' => $dept->has_BuHweiHwaWen, //是否招收不具華文基礎學生
                            'evaluation' => $dept->evaluation, //系所評鑑等級
                        ]
                    );

                    $this->GraduateDepartmentApplicationDocumentModel->where('dept_id', '=', $dept->id)->forceDelete();

                    $this->PaperApplicationDocumentAddressModel->where('dept_id', '=', $dept->id)->forceDelete();

                    if ($dept->admission_selection_quota > 0) {
                        $docs = $this->GraduateDepartmentHistoryApplicationDocumentModel->where('dept_id', '=', $dept->id)
                            ->where('history_id', '=', $dept->history_id)->with(['paper' => function ($query) use ($dept) {
                                $query->where('dept_id', '=', $dept->id);
                            }])->get();

                        foreach ($docs as $doc) {
                            DB::table('graduate_dept_application_docs')->insert([
                                'dept_id' => $doc->dept_id,
                                'type_id' => $doc->type_id,
                                'description' => $doc->description,
                                'eng_description' => $doc->eng_description, //'學制描述
                                'modifiable' => $doc->modifiable, //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
                                'required' => $doc->required, //上學年本地生未招足名額（二技參照學士）
                                'updated_at' => Carbon::now()->toIso8601String(),
                                'created_at' => Carbon::now()->toIso8601String(),
                            ]);

                            if ($doc->paper != NULL) {
                                DB::table('paper_application_document_address')->insert([
                                    'dept_id' => $doc->dept_id,
                                    'type_id' => $doc->type_id,
                                    'address' => $doc->paper->address,
                                    'recipient' => $doc->paper->recipient,
                                    'phone' => $doc->paper->phone,
                                    'email' => $doc->paper->email,
                                    'deadline' => $doc->paper->deadline,
                                    'updated_at' => Carbon::now()->toIso8601String(),
                                    'created_at' => Carbon::now()->toIso8601String(),
                                ]);
                            }
                        }
                    }
                }
            });

            $messages = ['done！'];

            return response()->json(compact('messages'));
        }

        $messages = ['school_code 或所屬 system_id 不存在！'];

        return response()->json(compact('messages'), 404);
    }
}
