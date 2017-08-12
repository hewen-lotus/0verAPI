<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DeptApplicationDocsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        $dept_application_docs = [];

        $dept_history_application_docs = [];

        $dept_used = collect([]);

        $two_year_tech_dept_application_docs = [];

        $two_year_tech_dept_history_application_docs = [];

        $two_year_tech_used = collect([]);

        $master_dept_application_docs = [];

        $master_dept_history_application_docs = [];

        $master_dept_used = collect([]);

        $phd_dept_application_docs = [];

        $phd_dept_history_application_docs = [];

        $phd_dept_used = collect([]);

        // 學士學制
        $depts = DB::table('department_history_data')->get();

        foreach ($depts as $dept) {
            if (!$dept_used->contains($dept->id)) {
                $dept_application_docs[] =
                    [
                        'dept_id' => $dept->id,
                        'type_id' => $dept_highest_id,
                        'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'modifiable' => 0,
                        'required' => 1,
                        'created_at' => Carbon::now()->toIso8601String(),
                        'updated_at' => Carbon::now()->toIso8601String()
                    ];

                $dept_application_docs[] =
                    [
                        'dept_id' => $dept->id,
                        'type_id' => $dept_score_id,
                        'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'modifiable' => 0,
                        'required' => 1,
                        'created_at' => Carbon::now()->toIso8601String(),
                        'updated_at' => Carbon::now()->toIso8601String()
                    ];

                $dept_used->push($dept->id);
            }

            $dept_history_application_docs[] =
                [
                    'dept_id' => $dept->id,
                    'type_id' => $dept_highest_id,
                    'history_id' => $dept->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ];

            $dept_history_application_docs[] =
                [
                    'dept_id' => $dept->id,
                    'type_id' => $dept_score_id,
                    'history_id' => $dept->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ];
        }

        // 二技
        $two_year_depts = DB::table('two_year_tech_department_history_data')->get();

        foreach ($two_year_depts as $two_year_dept) {
            if (!$two_year_tech_used->contains($two_year_dept->id)) {
                $two_year_tech_dept_application_docs[] =
                    [
                        'dept_id' => $two_year_dept->id,
                        'type_id' => $two_year_highest_id,
                        'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'modifiable' => 0,
                        'required' => 1,
                        'created_at' => Carbon::now()->toIso8601String(),
                        'updated_at' => Carbon::now()->toIso8601String()
                    ];

                $two_year_tech_dept_application_docs[] =
                    [
                        'dept_id' => $two_year_dept->id,
                        'type_id' => $two_year_score_id,
                        'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'modifiable' => 0,
                        'required' => 1,
                        'created_at' => Carbon::now()->toIso8601String(),
                        'updated_at' => Carbon::now()->toIso8601String()
                    ];

                $two_year_tech_used->push($two_year_dept->id);
            }

            $two_year_tech_dept_history_application_docs[] =
                [
                    'dept_id' => $two_year_dept->id,
                    'type_id' => $two_year_highest_id,
                    'history_id' => $two_year_dept->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ];

            $two_year_tech_dept_history_application_docs[] =
                [
                    'dept_id' => $two_year_dept->id,
                    'type_id' => $two_year_score_id,
                    'history_id' => $two_year_dept->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ];
        }

        // 碩
        $master_depts = DB::table('graduate_department_history_data')->where('system_id', '=', 3)->get();

        foreach ($master_depts as $master_dept) {
            if (!$master_dept_used->contains($master_dept->id)) {
                $master_dept_application_docs[] =
                    [
                        'dept_id' => $master_dept->id,
                        'type_id' => $master_highest_id,
                        'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'modifiable' => 0,
                        'required' => 1,
                        'created_at' => Carbon::now()->toIso8601String(),
                        'updated_at' => Carbon::now()->toIso8601String()
                    ];

                $master_dept_application_docs[] =
                    [
                        'dept_id' => $master_dept->id,
                        'type_id' => $master_score_id,
                        'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'modifiable' => 0,
                        'required' => 1,
                        'created_at' => Carbon::now()->toIso8601String(),
                        'updated_at' => Carbon::now()->toIso8601String()
                    ];

                $master_dept_used->push($master_dept->id);
            }

            $master_dept_history_application_docs[] =
                [
                    'dept_id' => $master_dept->id,
                    'type_id' => $master_highest_id,
                    'history_id' => $master_dept->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ];

            $master_dept_history_application_docs[] =
                [
                    'dept_id' => $master_dept->id,
                    'type_id' => $master_score_id,
                    'history_id' => $master_dept->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ];
        }

        // 博
        $phd_depts = DB::table('graduate_department_history_data')->where('system_id', '=', 4)->get();

        foreach ($phd_depts as $phd_dept) {
            if (!$phd_dept_used->contains($phd_dept->id)) {
                $phd_dept_application_docs[] =
                    [
                        'dept_id' => $phd_dept->id,
                        'type_id' => $phd_highest_id,
                        'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'modifiable' => 0,
                        'required' => 1,
                        'created_at' => Carbon::now()->toIso8601String(),
                        'updated_at' => Carbon::now()->toIso8601String()
                    ];

                $phd_dept_application_docs[] =
                    [
                        'dept_id' => $phd_dept->id,
                        'type_id' => $phd_score_id,
                        'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                        'modifiable' => 0,
                        'required' => 1,
                        'created_at' => Carbon::now()->toIso8601String(),
                        'updated_at' => Carbon::now()->toIso8601String()
                    ];

                $phd_dept_used->push($phd_dept->id);
            }

            $phd_dept_history_application_docs[] =
                [
                    'dept_id' => $phd_dept->id,
                    'type_id' => $phd_highest_id,
                    'history_id' => $phd_dept->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ];

            $phd_dept_history_application_docs[] =
                [
                    'dept_id' => $phd_dept->id,
                    'type_id' => $phd_score_id,
                    'history_id' => $phd_dept->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ];
        }

        DB::transaction(function () use (
            $dept_application_docs,
            $dept_history_application_docs,
            $two_year_tech_dept_application_docs,
            $two_year_tech_dept_history_application_docs,
            $master_dept_application_docs,
            $master_dept_history_application_docs,
            $phd_dept_application_docs,
            $phd_dept_history_application_docs
        ) {
            DB::table('dept_application_docs')->insert($dept_application_docs);

            DB::table('dept_history_application_docs')->insert($dept_history_application_docs);

            DB::table('two_year_tech_dept_application_docs')->insert($two_year_tech_dept_application_docs);

            DB::table('two_year_tech_dept_history_application_docs')->insert($two_year_tech_dept_history_application_docs);

            DB::table('graduate_dept_application_docs')->insert($master_dept_application_docs);

            DB::table('graduate_dept_history_application_docs')->insert($master_dept_history_application_docs);

            DB::table('graduate_dept_application_docs')->insert($phd_dept_application_docs);

            DB::table('graduate_dept_history_application_docs')->insert($phd_dept_history_application_docs);
        });
    }
}
