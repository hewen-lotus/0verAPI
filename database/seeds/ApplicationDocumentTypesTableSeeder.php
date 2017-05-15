<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class ApplicationDocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('application_document_types')->insert([
            [
                'name' => '學歷證件',
                'eng_name' => 'student identify',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '歷年成績單',
                'eng_name' => 'transcription',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '自傳/簡歷/履歷/簡介',
                'eng_name' => 'resume',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '推薦函/推薦信',
                'eng_name' => 'recommendation letter',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '檢定/測試/測驗/考試/證明/證書/證照',
                'eng_name' => 'certification',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '競賽表現/獲獎紀錄',
                'eng_name' => 'award',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '專題/論文著作',
                'eng_name' => 'academic work',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '學習計劃/讀書計劃/研究計劃/生涯規劃',
                'eng_name' => 'study plan',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '社團活動/課外活動/服務經歷',
                'eng_name' => 'extra-curriculum activity',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '作品/著作/演出',
                'eng_name' => 'piece',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '其他有助於審查之資料',
                'eng_name' => 'other documents',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'name' => '繳費證明',
                'eng_name' => 'receipt',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ]
        ]);
    }
}
