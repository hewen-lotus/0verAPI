<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class SystemDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_data')->insert([
            [
                'school_code' => '01',
                'type' => '學士學制',
                'description' => '中文學制描述',
                'eng_description' => 'eng_description',
                'last_year_admission_amount' => '348',
                'last_year_surplus_admission_quota' => NULL,
                'ratify_expanded_quota' => '150',
                'ratify_quota_for_self_enrollment' => NULL,
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'school_code' => '01',
                'system' => '碩士學制',
                'description' => '中文學制描述',
                'eng_description' => 'eng_description',
                'last_year_admission_amount' => '387',
                'last_year_surplus_admission_quota' => NULL,
                'ratify_expanded_quota' => NULL,
                'ratify_quota_for_self_enrollment' => NULL,
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'school_code' => '01',
                'system' => '博士學制',
                'description' => '中文學制描述',
                'eng_description' => 'eng_description',
                'last_year_admission_amount' => '76',
                'last_year_surplus_admission_quota' => '51',
                'ratify_expanded_quota' => NULL,
                'ratify_quota_for_self_enrollment' => NULL,
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ]
        ]);
    }
}
