<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class EvaluationLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('evaluation_levels')->insert([
            ['title' => '一等','eng_title' => 'First Grade','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '二等','eng_title' => 'Second Grade','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '三等','eng_title' => 'Third Grade','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '通過','eng_title' => 'Passed','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '有條件通過','eng_title' => 'Passed with Conditions','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '不通過','eng_title' => 'Failed','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '免評(通過AACSB)','eng_title' => 'AACSB Passed','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '免評(通過IEET)','eng_title' => 'IEET Passed','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '免評(通過TMAC)','eng_title' => 'TMAC Passed','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '免評(通過化學學門評鑑)','eng_title' => 'Chemical Society Passed','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '免評(通過台灣文史系所評鑑)','eng_title' => 'Literature and History Passed','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '免評(通過TNAC)','eng_title' => 'TNAC Passed','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '免評(通過ACCSB)','eng_title' => 'ACCSB Passed','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '未評鑑','eng_title' => 'Not Evaluated','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
        ]);
    }
}
