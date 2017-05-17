<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class SchoolDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_data')->insert([
            [
                'id' => '01',
                'type' => '國立大學',
                'title' => '國立臺灣大學',
                'eng_title' => 'National  Taiwan University',
                'address' => '10617臺北市羅斯福路4段1號',
                'eng_address' => 'No. 1, Sec. 4, Roosevelt Road, Taipei, 10617 Taiwan R.O.C.',
                'phone' => '886-2-33662388轉203',
                'fax' => '886-2-23638200',
                'url' => 'http://www.ntu.edu.tw',
                'eng_url' => 'http://www.ntu.edu.tw',
                'organization' => '註冊組',
                'eng_organization' => 'eng_organization',
                'sort_order' => '1',
                'has_five_year_student_allowed' => true,
                'rule_of_five_year_student' => '中五招收規則.........',
                'has_self_enrollment' => true,
                'approve_no_of_self_enrollment' => '臺教高(四)字第1040109682號',
                'dorm_info' => '新生保障住宿',
                'eng_dorm_info' => 'eng_dorm_info',
                'has_scholarship' => true,
                'scholarship_url' => 'http://gocfs.osa.ntu.edu.tw/news/news.php?class=101',
                'eng_scholarship_url' => 'http://gocfs.osa.ntu.edu.tw/news/news.php?class=101',
                'scholarship_dept' => '學務處生活輔導組及僑生及陸生輔導組',
                'eng_scholarship_dept' => 'eng_scholarship_dept',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'id' => '02',
                'type' => '國立大學',
                'title' => '國立成功大學',
                'eng_title' => 'National  Taiwan University',
                'address' => '10617臺北市羅斯福路4段1號',
                'eng_address' => 'No. 1, Sec. 4, Roosevelt Road, Taipei, 10617 Taiwan R.O.C.',
                'phone' => '886-2-33662388轉203',
                'fax' => '886-2-23638200',
                'url' => 'http://www.ntu.edu.tw',
                'eng_url' => 'http://www.ntu.edu.tw',
                'organization' => '註冊組',
                'eng_organization' => 'eng_organization',
                'sort_order' => '1',
                'has_five_year_student_allowed' => true,
                'rule_of_five_year_student' => '中五招收規則.........',
                'has_self_enrollment' => true,
                'approve_no_of_self_enrollment' => '臺教高(四)字第1040109682號',
                'dorm_info' => '新生保障住宿',
                'eng_dorm_info' => 'eng_dorm_info',
                'has_scholarship' => true,
                'scholarship_url' => 'http://gocfs.osa.ntu.edu.tw/news/news.php?class=101',
                'eng_scholarship_url' => 'http://gocfs.osa.ntu.edu.tw/news/news.php?class=101',
                'scholarship_dept' => '學務處生活輔導組及僑生及陸生輔導組',
                'eng_scholarship_dept' => 'eng_scholarship_dept',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'id' => '04',
                'type' => '國立大學',
                'title' => '國立暨南國際大學',
                'eng_title' => 'National  Taiwan University',
                'address' => '10617臺北市羅斯福路4段1號',
                'eng_address' => 'No. 1, Sec. 4, Roosevelt Road, Taipei, 10617 Taiwan R.O.C.',
                'phone' => '886-2-33662388轉203',
                'fax' => '886-2-23638200',
                'url' => 'http://www.ntu.edu.tw',
                'eng_url' => 'http://www.ntu.edu.tw',
                'organization' => '註冊組',
                'eng_organization' => 'eng_organization',
                'sort_order' => '1',
                'has_five_year_student_allowed' => true,
                'rule_of_five_year_student' => '中五招收規則.........',
                'has_self_enrollment' => true,
                'approve_no_of_self_enrollment' => '臺教高(四)字第1040109682號',
                'dorm_info' => '新生保障住宿',
                'eng_dorm_info' => 'eng_dorm_info',
                'has_scholarship' => true,
                'scholarship_url' => 'http://gocfs.osa.ntu.edu.tw/news/news.php?class=101',
                'eng_scholarship_url' => 'http://gocfs.osa.ntu.edu.tw/news/news.php?class=101',
                'scholarship_dept' => '學務處生活輔導組及僑生及陸生輔導組',
                'eng_scholarship_dept' => 'eng_scholarship_dept',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ]
        ]);
    }
}
