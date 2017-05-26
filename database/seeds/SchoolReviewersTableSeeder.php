<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class SchoolReviewersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!App::environment('production')) {
            DB::table('school_reviewers')->insert([
                [
                    'username' => 'reviewer1',
                    'school_code' => '01',
                    'organization' => '註冊組',
                    'has_admin' => true,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'reviewer2',
                    'school_code' => '02',
                    'organization' => '註冊組',
                    'has_admin' => false,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ],

                [
                    'username' => 'reviewer3',
                    'school_code' => '03',
                    'organization' => '註冊組',
                    'has_admin' => false,
                    'created_at' => Carbon::now()->toIso8601String(),
                    'updated_at' => Carbon::now()->toIso8601String()
                ]
            ]);
        }
    }
}
