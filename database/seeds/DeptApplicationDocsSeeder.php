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

        // 學士學制
        $depts = DB::table('department_data')->select('id')->distinct()->get();

        foreach ($depts as $dept) {
            DB::table('dept_application_docs')->insert([
                [
                    'dept_id' => $dept->id,
                    'type_id' => $dept_highest_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
                [
                    'dept_id' => $dept->id,
                    'type_id' => $dept_score_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
            ]);

            $history = DB::table('department_history_data')->select('history_id')->where('id', '=', $dept->id)->first();

            DB::table('dept_history_application_docs')->insert([
                [
                    'dept_id' => $dept->id,
                    'type_id' => $dept_highest_id,
                    'history_id' => $history->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
                [
                    'dept_id' => $dept->id,
                    'type_id' => $dept_score_id,
                    'history_id' => $history->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
            ]);
        }

        $two_year_depts = DB::table('two_year_tech_department_data')->select('id')->distinct()->get();

        foreach ($two_year_depts as $two_year_dept) {
            DB::table('two_year_tech_dept_application_docs')->insert([
                [
                    'dept_id' => $two_year_dept->id,
                    'type_id' => $two_year_highest_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
                [
                    'dept_id' => $two_year_dept->id,
                    'type_id' => $two_year_score_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
            ]);

            $history = DB::table('two_year_tech_department_history_data')->select('history_id')->where('id', '=', $two_year_dept->id)->first();

            DB::table('two_year_tech_dept_history_application_docs')->insert([
                [
                    'dept_id' => $two_year_dept->id,
                    'type_id' => $two_year_highest_id,
                    'history_id' => $history->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
                [
                    'dept_id' => $two_year_dept->id,
                    'type_id' => $two_year_score_id,
                    'history_id' => $history->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
            ]);
        }

        $master_depts = DB::table('graduate_department_data')->select('id')->distinct()->where('system_id', '=', 3)->get();

        foreach ($master_depts as $master_dept) {
            DB::table('graduate_dept_application_docs')->insert([
                [
                    'dept_id' => $master_dept->id,
                    'type_id' => $master_highest_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
                [
                    'dept_id' => $master_dept->id,
                    'type_id' => $master_score_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
            ]);

            $history = DB::table('graduate_department_history_data')->select('history_id')->where('id', '=', $master_dept->id)->where('system_id', '=', 3)->first();

            DB::table('graduate_dept_history_application_docs')->insert([
                [
                    'dept_id' => $master_dept->id,
                    'type_id' => $master_highest_id,
                    'history_id' => $history->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
                [
                    'dept_id' => $master_dept->id,
                    'type_id' => $master_score_id,
                    'history_id' => $history->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
            ]);
        }

        $phd_depts = DB::table('graduate_department_data')->select('id')->distinct()->where('system_id', '=', 4)->get();

        foreach ($phd_depts as $phd_dept) {
            DB::table('graduate_dept_application_docs')->insert([
                [
                    'dept_id' => $phd_dept->id,
                    'type_id' => $phd_highest_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
                [
                    'dept_id' => $phd_dept->id,
                    'type_id' => $phd_score_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
            ]);

            $history = DB::table('graduate_department_history_data')->select('history_id')->where('id', '=', $phd_dept->id)->where('system_id', '=', 4)->first();

            DB::table('graduate_dept_history_application_docs')->insert([
                [
                    'dept_id' => $phd_dept->id,
                    'type_id' => $phd_highest_id,
                    'history_id' => $history->history_id,
                    'description' => '請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'eng_description' => '請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等',
                    'modifiable' => 0,
                    'required' => 1,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],
                [
                    'dept_id' => $phd_dept->id,
                    'type_id' => $phd_score_id,
                    'history_id' => $history->history_id,
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
}
