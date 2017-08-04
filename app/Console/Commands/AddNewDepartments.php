<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Excel;
use Carbon\Carbon;

class AddNewDepartments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:add-new-departments {file_path : 檔案路徑}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '新增系所啦 (`・ω・´) ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // csv 檔只需要 id, school_code, system_id, title, eng_title
        //             ^        ^           ^
        //          系所代碼   學校代碼     學制代碼
        if ($this->confirm('此功能將直接修改資料庫資料，是否繼續？')) {
            $path = $this->argument('file_path');

            // $csv_enctype = mb_detect_encoding(file_get_contents($path), 'UTF-8, BIG-5', true);

            $input = Excel::load($path, function($reader) {
                // Getting all results
                $reader->calculate(false);
            })->get();

            DB::transaction(function () use ($input) {
                // 各學制的最高學歷證明 id
                $dept_highest_id = DB::table('application_document_types')
                    ->where('system_id', '=', 1)->where('name', '=', '最高學歷證明')->value('id');

                $two_year_highest_id = DB::table('application_document_types')
                    ->where('system_id', '=', 2)->where('name', '=', '最高學歷證明')->value('id');

                $master_highest_id = DB::table('application_document_types')
                    ->where('system_id', '=', 3)->where('name', '=', '最高學歷證明')->value('id');

                $phd_highest_id = DB::table('application_document_types')
                    ->where('system_id', '=', 4)->where('name', '=', '最高學歷證明')->value('id');

                // 各學制的歷年成績單 id
                $dept_score_id = DB::table('application_document_types')
                    ->where('system_id', '=', 1)->where('name', 'like', '%歷年成績單%')->value('id');

                $two_year_score_id = DB::table('application_document_types')
                    ->where('system_id', '=', 2)->where('name', 'like', '%歷年成績單%')->value('id');

                $master_score_id = DB::table('application_document_types')
                    ->where('system_id', '=', 3)->where('name', 'like', '%歷年成績單%')->value('id');

                $phd_score_id = DB::table('application_document_types')
                    ->where('system_id', '=', 4)->where('name', 'like', '%歷年成績單%')->value('id');

                foreach ($input as $data) {
                    $system_id = $data['system_id'];

                    if ($system_id == 1) {
                        DB::table('department_data')->insert([
                            'id' => $data['id'],
                            'school_code' => $data['school_code'],
                            'card_code' => $data['card_code'],
                            'title' => $data['title'],
                            'eng_title' => $data['eng_title'],
                            'description' => '請輸入系所中文描述',
                            'eng_description' => 'eng_description',
                            'memo' => NULL,
                            'url' => 'http://www.edu.tw',
                            'eng_url' => 'http://www.edu.tw',
                            'last_year_admission_placement_amount' => 0,
                            'last_year_admission_placement_quota' => 0,
                            'admission_placement_quota' => 0,
                            'decrease_reason_of_admission_placement' => NULL,
                            'last_year_personal_apply_offer' => '0',
                            'last_year_personal_apply_amount' => '0',
                            'admission_selection_quota' => '0',
                            'has_self_enrollment' => false,
                            'self_enrollment_quota' => NULL,
                            'has_special_class' => false,
                            'has_foreign_special_class' => false,
                            'special_dept_type' => NULL,
                            'gender_limit' => NULL,
                            'sort_order' => 99,
                            'has_birth_limit' => false,
                            'birth_limit_after' => NULL,
                            'birth_limit_before' => NULL,
                            'has_review_fee' => false,
                            'has_eng_taught' => false,
                            'has_disabilities' => false,
                            'has_buhweihwawen' => true,
                            'main_group' => 4,
                            'sub_group' => 4,
                            'evaluation' => 4,
                            'created_at' => Carbon::now()->toIso8601String(),
                            'updated_at' => Carbon::now()->toIso8601String()
                        ]);

                        $history_id = DB::table('department_history_data')->insertGetId([
                            'id' => $data['id'],
                            'school_code' => $data['school_code'],
                            'card_code' => $data['card_code'],
                            'title' => $data['title'],
                            'eng_title' => $data['eng_title'],
                            'description' => '請輸入系所中文描述',
                            'eng_description' => 'eng_description',
                            'memo' => NULL,
                            'url' => 'http://www.edu.tw',
                            'eng_url' => 'http://www.edu.tw',
                            'last_year_admission_placement_amount' => 0,
                            'last_year_admission_placement_quota' => 0,
                            'admission_placement_quota' => 0,
                            'decrease_reason_of_admission_placement' => NULL,
                            'last_year_personal_apply_offer' => '0',
                            'last_year_personal_apply_amount' => '0',
                            'admission_selection_quota' => '0',
                            'has_self_enrollment' => false,
                            'self_enrollment_quota' => NULL,
                            'has_special_class' => false,
                            'has_foreign_special_class' => false,
                            'special_dept_type' => NULL,
                            'gender_limit' => NULL,
                            'sort_order' => 99,
                            'has_birth_limit' => false,
                            'birth_limit_after' => NULL,
                            'birth_limit_before' => NULL,
                            'has_review_fee' => false,
                            'has_eng_taught' => false,
                            'has_disabilities' => false,
                            'has_buhweihwawen' => true,
                            'main_group' => 4,
                            'sub_group' => 4,
                            'evaluation' => 4,
                            'ip_address' => '127.0.0.1',
                            'info_status' => 'editing',
                            'quota_status' => 'editing',
                            'created_by' => 'admin1',
                            'created_at' => Carbon::now()->toIso8601String(),
                            'updated_at' => Carbon::now()->toIso8601String()
                        ]);

                        DB::table('dept_application_docs')->insert([
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $dept_highest_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $dept_score_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                        ]);

                        DB::table('dept_history_application_docs')->insert([
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $dept_highest_id,
                                'history_id' => $history_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $dept_score_id,
                                'history_id' => $history_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                        ]);
                    } else if ($system_id == 2) {
                        DB::table('two_year_tech_department_data')->insert([
                            'id' => $data['id'],
                            'school_code' => $data['school_code'],
                            'title' => $data['title'],
                            'eng_title' => $data['eng_title'],
                            'description' => '請輸入系所中文描述',
                            'eng_description' => 'eng_description',
                            'memo' => NULL,
                            'url' => 'http://www.edu.tw',
                            'eng_url' => 'http://www.edu.tw',
                            'last_year_personal_apply_offer' => 0,
                            'last_year_personal_apply_amount' => 0,
                            'admission_selection_quota' => 0,
                            'has_self_enrollment' => false,
                            'has_rijian' => false,
                            'has_special_class' => false,
                            'has_foreign_special_class' => false,
                            'sort_order' => 99,
                            'has_birth_limit' => false,
                            'has_review_fee' => false,
                            'has_eng_taught' => false,
                            'has_disabilities' => false,
                            'has_buhweihwawen' => false,
                            'main_group' => 1,
                            'sub_group' => NULL,
                            'evaluation' => 1,
                            'created_at' => Carbon::now()->toIso8601String(),
                            'updated_at' => Carbon::now()->toIso8601String()
                        ]);

                        $history_id = DB::table('two_year_tech_department_history_data')->insertGetId([
                            'id' => $data['id'],
                            'school_code' => $data['school_code'],
                            'title' => $data['title'],
                            'eng_title' => $data['eng_title'],
                            'description' => '請輸入系所中文描述',
                            'eng_description' => 'eng_description',
                            'url' => 'http://www.edu.tw',
                            'eng_url' => 'http://www.edu.tw',
                            'last_year_personal_apply_offer' => 0,
                            'last_year_personal_apply_amount' => 0,
                            'admission_selection_quota' => 0,
                            'has_self_enrollment' => false,
                            'has_rijian' => false,
                            'has_special_class' => false,
                            'has_foreign_special_class' => false,
                            'sort_order' => 99,
                            'has_birth_limit' => false,
                            'has_review_fee' => false,
                            'has_eng_taught' => false,
                            'has_disabilities' => false,
                            'has_buhweihwawen' => false,
                            'main_group' => 1,
                            'sub_group' => NULL,
                            'evaluation' => 1,
                            'ip_address' => '127.0.0.1',
                            'info_status' => 'editing',
                            'quota_status' => 'editing',
                            'created_by' => 'admin1',
                            'created_at' => Carbon::now()->toIso8601String(),
                            'updated_at' => Carbon::now()->toIso8601String()
                        ]);

                        DB::table('two_year_tech_dept_application_docs')->insert([
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $two_year_highest_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $two_year_score_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                        ]);

                        DB::table('two_year_tech_dept_history_application_docs')->insert([
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $two_year_highest_id,
                                'history_id' => $history_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $two_year_score_id,
                                'history_id' => $history_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                        ]);
                    } else if ($system_id == 3) {
                        DB::table('graduate_department_data')->insert([
                            'id' => $data['id'],
                            'school_code' => $data['school_code'],
                            'title' => $data['title'],
                            'eng_title' => $data['eng_title'],
                            'system_id' => 3,
                            'description' => '請輸入系所中文描述',
                            'eng_description' => 'eng_description',
                            'url' => 'http://www.edu.tw',
                            'eng_url' => 'http://www.edu.tw',
                            'last_year_personal_apply_offer' => 0,
                            'last_year_personal_apply_amount' => 0,
                            'admission_selection_quota' => 0,
                            'has_self_enrollment' => false,
                            'has_special_class' => false,
                            'has_foreign_special_class' => false,
                            'sort_order' => 99,
                            'has_birth_limit' => false,
                            'has_review_fee' => false,
                            'has_eng_taught' => false,
                            'has_disabilities' => false,
                            'has_buhweihwawen' => false,
                            'main_group' => 4,
                            'sub_group' => NULL,
                            'evaluation' => 4,
                            'created_at' => Carbon::now()->toIso8601String(),
                            'updated_at' => Carbon::now()->toIso8601String()
                        ]);

                        $history_id = DB::table('graduate_department_history_data')->insertGetId([
                            'id' => $data['id'],
                            'school_code' => $data['school_code'],
                            'title' => $data['title'],
                            'eng_title' => $data['eng_title'],
                            'system_id' => 3,
                            'description' => '請輸入系所中文描述',
                            'eng_description' => 'eng_description',
                            'url' => 'http://www.edu.tw',
                            'eng_url' => 'http://www.edu.tw',
                            'last_year_personal_apply_offer' => 0,
                            'last_year_personal_apply_amount' => 0,
                            'admission_selection_quota' => 0,
                            'has_self_enrollment' => false,
                            'has_special_class' => false,
                            'has_foreign_special_class' => false,
                            'sort_order' => 99,
                            'has_birth_limit' => false,
                            'has_review_fee' => false,
                            'has_eng_taught' => false,
                            'has_disabilities' => false,
                            'has_buhweihwawen' => false,
                            'main_group' => 4,
                            'sub_group' => NULL,
                            'evaluation' => 4,
                            'ip_address' => '127.0.0.1',
                            'info_status' => 'editing',
                            'quota_status' => 'editing',
                            'created_by' => 'admin1',
                            'created_at' => Carbon::now()->toIso8601String(),
                            'updated_at' => Carbon::now()->toIso8601String()
                        ]);

                        DB::table('graduate_dept_application_docs')->insert([
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $master_highest_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $master_score_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                        ]);

                        DB::table('graduate_dept_history_application_docs')->insert([
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $master_highest_id,
                                'history_id' => $history_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $master_score_id,
                                'history_id' => $history_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                        ]);
                    } else if ($system_id == 4) {
                        DB::table('graduate_department_data')->insert([
                            'id' => $data['id'],
                            'school_code' => $data['school_code'],
                            'title' => $data['title'],
                            'eng_title' => $data['eng_title'],
                            'system_id' => 4,
                            'description' => '請輸入系所中文描述',
                            'eng_description' => 'eng_description',
                            'url' => 'http://www.edu.tw',
                            'eng_url' => 'http://www.edu.tw',
                            'last_year_personal_apply_offer' => 0,
                            'last_year_personal_apply_amount' => 0,
                            'admission_selection_quota' => 0,
                            'has_self_enrollment' => false,
                            'has_special_class' => false,
                            'has_foreign_special_class' => false,
                            'sort_order' => 99,
                            'has_birth_limit' => false,
                            'has_review_fee' => false,
                            'has_eng_taught' => false,
                            'has_disabilities' => false,
                            'has_buhweihwawen' => false,
                            'main_group' => 4,
                            'sub_group' => NULL,
                            'evaluation' => 4,
                            'created_at' => Carbon::now()->toIso8601String(),
                            'updated_at' => Carbon::now()->toIso8601String()
                        ]);

                        $history_id = DB::table('graduate_department_history_data')->insertGetId([
                            'id' => $data['id'],
                            'school_code' => $data['school_code'],
                            'title' => $data['title'],
                            'eng_title' => $data['eng_title'],
                            'system_id' => 4,
                            'description' => '請輸入系所中文描述',
                            'eng_description' => 'eng_description',
                            'url' => 'http://www.edu.tw',
                            'eng_url' => 'http://www.edu.tw',
                            'last_year_personal_apply_offer' => 0,
                            'last_year_personal_apply_amount' => 0,
                            'admission_selection_quota' => 0,
                            'has_self_enrollment' => false,
                            'has_special_class' => false,
                            'has_foreign_special_class' => false,
                            'sort_order' => 99,
                            'has_birth_limit' => false,
                            'has_review_fee' => false,
                            'has_eng_taught' => false,
                            'has_disabilities' => false,
                            'has_buhweihwawen' => false,
                            'main_group' => 4,
                            'sub_group' => NULL,
                            'evaluation' => 4,
                            'ip_address' => '127.0.0.1',
                            'info_status' => 'editing',
                            'quota_status' => 'editing',
                            'created_by' => 'admin1',
                            'created_at' => Carbon::now()->toIso8601String(),
                            'updated_at' => Carbon::now()->toIso8601String()
                        ]);

                        DB::table('graduate_dept_application_docs')->insert([
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $phd_highest_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $phd_score_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                        ]);

                        DB::table('graduate_dept_history_application_docs')->insert([
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $phd_highest_id,
                                'history_id' => $history_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                            [
                                'dept_id' => $data['id'],
                                'type_id' => $phd_score_id,
                                'history_id' => $history_id,
                                'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                                'modifiable' => 0,
                                'required' => 1,
                                'created_at' => Carbon::now()->toIso8601String(),
                                'updated_at' => Carbon::now()->toIso8601String()
                            ],
                        ]);
                    }
                }
            });
        } else {
            $this->error('離開');

            return 1;
        }

        $this->info('做完了 ^^');

        return 0;
    }
}
