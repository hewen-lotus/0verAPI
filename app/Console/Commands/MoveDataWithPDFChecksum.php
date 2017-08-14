<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\GuidelinesReplyFormRecord;
use App\SchoolHistoryData;
use App\SchoolData;
use App\SystemData;
use App\DepartmentHistoryApplicationDocument;
use App\GraduateDepartmentHistoryApplicationDocument;
use App\TwoYearTechDepartmentHistoryApplicationDocument;
use App\DepartmentData;
use App\DepartmentApplicationDocument;
use App\TwoYearTechDepartmentData;
use App\TwoYearTechDepartmentApplicationDocument;
use App\GraduateDepartmentData;
use App\GraduateDepartmentApplicationDocument;
use App\PaperApplicationDocumentAddress;

use DB;
use Carbon\Carbon;
use Auth;
use Excel;

class MoveDataWithPDFChecksum extends Command
{
    /** @var GuidelinesReplyFormRecord */
    private $GuidelinesReplyFormRecordModel;

    /** @var SchoolHistoryData */
    private $SchoolHistoryDataModel;

    /** @var SchoolData */
    private $SchoolDataModel;

    /** @var SystemData */
    private $SystemDataModel;

    /** @var DepartmentData */
    private $DepartmentDataModel;

    /** @var DepartmentApplicationDocument */
    private $DepartmentApplicationDocumentModel;

    /** @var DepartmentHistoryApplicationDocument */
    private $DepartmentHistoryApplicationDocumentModel;

    /** @var PaperApplicationDocumentAddress */
    private $PaperApplicationDocumentAddressModel;

    /** @var TwoYearTechDepartmentData */
    private $TwoYearTechDepartmentDataModel;

    /** @var TwoYearTechDepartmentHistoryApplicationDocument */
    private $TwoYearTechDepartmentHistoryApplicationDocumentModel;

    /** @var TwoYearTechDepartmentApplicationDocument */
    private $TwoYearTechDepartmentApplicationDocumentModel;

    /** @var GraduateDepartmentData */
    private $GraduateDepartmentDataModel;

    /** @var GraduateDepartmentHistoryApplicationDocument */
    private $GraduateDepartmentHistoryApplicationDocumentModel;

    /** @var GraduateDepartmentApplicationDocument */
    private $GraduateDepartmentApplicationDocumentModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update-with-pdf-checksum {file_path : 檔案路徑}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用 PDF Checksum 紀錄更新資料';

    /**
     * Create a new command instance.
     *
     * @param GuidelinesReplyFormRecord $GuidelinesReplyFormRecordModel
     * @param SchoolHistoryData $SchoolHistoryDataModel
     * @param SchoolData $SchoolDataModel
     * @param SystemData $SystemDataModel
     * @param DepartmentData $DepartmentDataModel
     * @param DepartmentApplicationDocument $DepartmentApplicationDocumentModel
     * @param PaperApplicationDocumentAddress $PaperApplicationDocumentAddressModel
     * @param DepartmentHistoryApplicationDocument $DepartmentHistoryApplicationDocumentModel
     * @param TwoYearTechDepartmentData $TwoYearTechDepartmentDataModel
     * @param TwoYearTechDepartmentHistoryApplicationDocument $TwoYearTechDepartmentHistoryApplicationDocumentModel
     * @param TwoYearTechDepartmentApplicationDocument $TwoYearTechDepartmentApplicationDocumentModel
     * @param GraduateDepartmentData $GraduateDepartmentDataModel
     * @param GraduateDepartmentHistoryApplicationDocument $GraduateDepartmentHistoryApplicationDocumentModel
     * @param GraduateDepartmentApplicationDocument $GraduateDepartmentApplicationDocumentModel
     * @return void
     */
    public function __construct(GuidelinesReplyFormRecord $GuidelinesReplyFormRecordModel,
                                SchoolHistoryData $SchoolHistoryDataModel,
                                SchoolData $SchoolDataModel,
                                SystemData $SystemDataModel,
                                DepartmentData $DepartmentDataModel,
                                DepartmentApplicationDocument $DepartmentApplicationDocumentModel,
                                PaperApplicationDocumentAddress $PaperApplicationDocumentAddressModel,
                                DepartmentHistoryApplicationDocument $DepartmentHistoryApplicationDocumentModel,
                                TwoYearTechDepartmentData $TwoYearTechDepartmentDataModel,
                                TwoYearTechDepartmentHistoryApplicationDocument $TwoYearTechDepartmentHistoryApplicationDocumentModel,
                                TwoYearTechDepartmentApplicationDocument $TwoYearTechDepartmentApplicationDocumentModel,
                                GraduateDepartmentData $GraduateDepartmentDataModel,
                                GraduateDepartmentHistoryApplicationDocument $GraduateDepartmentHistoryApplicationDocumentModel,
                                GraduateDepartmentApplicationDocument $GraduateDepartmentApplicationDocumentModel)
    {
        parent::__construct();

        $this->GuidelinesReplyFormRecordModel = $GuidelinesReplyFormRecordModel;

        $this->SchoolHistoryDataModel = $SchoolHistoryDataModel;

        $this->SchoolDataModel = $SchoolDataModel;

        $this->SystemDataModel = $SystemDataModel;

        $this->DepartmentDataModel = $DepartmentDataModel;

        $this->DepartmentApplicationDocumentModel = $DepartmentApplicationDocumentModel;

        $this->PaperApplicationDocumentAddressModel = $PaperApplicationDocumentAddressModel;

        $this->DepartmentHistoryApplicationDocumentModel = $DepartmentHistoryApplicationDocumentModel;

        $this->TwoYearTechDepartmentDataModel = $TwoYearTechDepartmentDataModel;

        $this->TwoYearTechDepartmentHistoryApplicationDocumentModel = $TwoYearTechDepartmentHistoryApplicationDocumentModel;

        $this->TwoYearTechDepartmentApplicationDocumentModel = $TwoYearTechDepartmentApplicationDocumentModel;

        $this->GraduateDepartmentDataModel = $GraduateDepartmentDataModel;

        $this->GraduateDepartmentHistoryApplicationDocumentModel = $GraduateDepartmentHistoryApplicationDocumentModel;

        $this->GraduateDepartmentApplicationDocumentModel = $GraduateDepartmentApplicationDocumentModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // csv 檔只需要 checksum
        if ($this->confirm('此功能將直接修改資料庫資料，是否繼續？')) {
            $path = $this->argument('file_path');

            $input = Excel::load($path, function($reader) {
                // Getting all results
                $reader->calculate(false);
            })->get();

            foreach ($input as $data) {
                $checksum = $data['checksum'];

                if ( $this->GuidelinesReplyFormRecordModel->where('checksum', '=', $checksum)->exists() ) {
                    DB::transaction(function () use ($checksum) {
                        $form_record = $this->GuidelinesReplyFormRecordModel->where('checksum', '=', $checksum)->first();

                        $school_code = $form_record->school_code;

                        $system_id = $form_record->system_id;

                        $record_data = json_decode($form_record->data, true);

                        $school = $this->SchoolHistoryDataModel->where('id', '=', $school_code)
                            ->where('history_id', '=', $record_data['school_history_data'])->first();

                        $this->SchoolDataModel->updateOrCreate(
                            ['id' => $school_code],
                            [
                                'history_id' => $record_data['school_history_data'], //從哪一筆歷史紀錄匯入的
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

                        $system = $school->systems()->where('type_id', '=', $system_id)
                            ->where('history_id', '=', $record_data['system_history_data'])->first();

                        $this->SystemDataModel->where('type_id', '=', $system_id)
                            ->where('school_code', '=', $school_code)
                            ->forceDelete();

                        DB::table('system_data')->insert([
                            'type_id' => $system_id,
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

                        $all_history_data = [];

                        foreach ($record_data['depts'] as &$dept_record) {
                            $all_history_data[] = $dept_record['history_id'];
                        }

                        if ($system_id == 1) {
                            $depts = DB::table('department_history_data')
                                ->whereIn('history_id', $all_history_data)
                                ->get();

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
                        } else if ($system_id == 2) {
                            $depts = DB::table('two_year_tech_department_history_data')
                                ->whereIn('history_id', $all_history_data)
                                ->get();

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
                        } else { // $system_id == 3 || $system_id == 4
                            $depts = DB::table('graduate_department_history_data')
                                ->whereIn('history_id', $all_history_data)
                                ->get();

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
                        }
                    });
                } else {
                    $this->error('checksum: ' . $checksum . ' 的資料不存在 QQ');
                }
            }
        } else {
            $this->error('離開');

            return 1;
        }

        $this->info('做完了 ^^');

        return 0;
    }
}
