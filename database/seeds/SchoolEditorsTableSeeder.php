<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class SchoolEditorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_editors')->insert([
            [
                'username' => 'editor1',
                'school_code' => '01',
                'organization' => '註冊組',
                'has_admin' => true,
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'username' => 'editor2',
                'school_code' => '02',
                'organization' => '註冊組',
                'has_admin' => true,
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()            ],
            [
                'username' => 'editor3',
                'school_code' => '04',
                'organization' => '註冊組',
                'has_admin' => true,
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ]
        ]);
    }
}
