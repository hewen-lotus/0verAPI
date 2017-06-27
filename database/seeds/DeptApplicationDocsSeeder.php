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
        // 各學制的最高學歷證明
        DB::insert('
            insert into dept_application_docs (dept_id, type_id, description, eng_description, modifiable, required, created_at, updated_at)
            select department_data.id, \'1\', \'請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'0\', \'1\', ?, ?
            from department_data;
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into two_year_tech_dept_application_docs (dept_id, type_id, description, eng_description, modifiable, required, created_at, updated_at)
            select two_year_tech_department_data.id, \'18\', \'請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'0\', \'1\', ?, ?
            from two_year_tech_department_data;
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into graduate_dept_application_docs (dept_id, type_id, description, eng_description, modifiable, required, created_at, updated_at)
            select graduate_department_data.id, \'37\', \'請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'0\', \'1\', ?, ?
            from graduate_department_data
            where system_id = \'3\';
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into graduate_dept_application_docs (dept_id, type_id, description, eng_description, modifiable, required, created_at, updated_at)
            select graduate_department_data.id, \'56\', \'請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'0\', \'1\', ?, ?
            from graduate_department_data
            where system_id = \'4\';
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        // 各學制的歷年成績單
        DB::insert('
            insert into dept_application_docs (dept_id, type_id, description, eng_description, modifiable, required, created_at, updated_at)
            select department_data.id, \'2\', \'請輸入詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'請輸入英文詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'0\', \'1\', ?, ?
            from department_data;
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into two_year_tech_dept_application_docs (dept_id, type_id, description, eng_description, modifiable, required, created_at, updated_at)
            select two_year_tech_department_data.id, \'19\', \'請輸入詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'請輸入英文詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'0\', \'1\', ?, ?
            from two_year_tech_department_data;
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into graduate_dept_application_docs (dept_id, type_id, description, eng_description, modifiable, required, created_at, updated_at)
            select graduate_department_data.id, \'38\', \'請輸入詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'請輸入英文詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'0\', \'1\', ?, ?
            from graduate_department_data
            where system_id = \'3\';
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into graduate_dept_application_docs (dept_id, type_id, description, eng_description, modifiable, required, created_at, updated_at)
            select graduate_department_data.id, \'57\', \'請輸入詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'請輸入英文詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'0\', \'1\', ?, ?
            from graduate_department_data
            where system_id = \'4\';
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        // 歷史資料表
        // 各學制的最高學歷證明
        DB::insert('
            insert into dept_history_application_docs (dept_id, type_id, history_id, description, eng_description, modifiable, required, created_at, updated_at)
            select department_history_data.id, \'1\', department_history_data.history_id, \'請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'0\', \'1\', ?, ?
            from department_history_data;
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into two_year_tech_dept_history_application_docs (dept_id, type_id, history_id, description, eng_description, modifiable, required, created_at, updated_at)
            select two_year_tech_department_history_data.id, \'18\', two_year_tech_department_history_data.history_id, \'請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'0\', \'1\', ?, ?
            from two_year_tech_department_history_data;
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into graduate_dept_history_application_docs (dept_id, type_id, history_id, description, eng_description, modifiable, required, created_at, updated_at)
            select graduate_department_history_data.id, \'37\', graduate_department_history_data.history_id, \'請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'0\', \'1\', ?, ?
            from graduate_department_history_data
            where system_id = \'3\';
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into graduate_dept_history_application_docs (dept_id, type_id, history_id, description, eng_description, modifiable, required, created_at, updated_at)
            select graduate_department_history_data.id, \'56\', graduate_department_history_data.history_id, \'請輸入詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'請輸入英文詳細說明，如份數與類型(畢業證書/修業證明/離校證明/在學證明)等\', \'0\', \'1\', ?, ?
            from graduate_department_history_data
            where system_id = \'4\';
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        // 各學制的歷年成績單
        DB::insert('
            insert into dept_history_application_docs (dept_id, type_id, history_id, description, eng_description, modifiable, required, created_at, updated_at)
            select department_history_data.id, \'2\', department_history_data.history_id, \'請輸入詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'請輸入英文詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'0\', \'1\', ?, ?
            from department_history_data;
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into two_year_tech_dept_history_application_docs (dept_id, type_id, history_id, description, eng_description, modifiable, required, created_at, updated_at)
            select two_year_tech_department_history_data.id, \'19\', two_year_tech_department_history_data.history_id, \'請輸入詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'請輸入英文詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'0\', \'1\', ?, ?
            from two_year_tech_department_history_data;
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into graduate_dept_history_application_docs (dept_id, type_id, history_id, description, eng_description, modifiable, required, created_at, updated_at)
            select graduate_department_history_data.id, \'38\', graduate_department_history_data.history_id, \'請輸入詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'請輸入英文詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'0\', \'1\', ?, ?
            from graduate_department_history_data
            where system_id = \'3\';
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);

        DB::insert('
            insert into graduate_dept_history_application_docs (dept_id, type_id, history_id, description, eng_description, modifiable, required, created_at, updated_at)
            select graduate_department_history_data.id, \'57\', graduate_department_history_data.history_id, \'請輸入詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'請輸入英文詳細說明，如份數與內容(全校名次及百分比對照表)等\', \'0\', \'1\', ?, ?
            from graduate_department_history_data
            where system_id = \'4\';
        ', [Carbon::now()->toIso8601String(), Carbon::now()->toIso8601String()]);
    }
}
