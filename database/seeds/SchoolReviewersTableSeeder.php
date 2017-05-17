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
        /*
        DB::table('school_reviewers')->insert(
            [
                'username' => 'admin1',
                'password' => Hash::make('admin123!@#'),
                'email' => 'a@a.a',
                'name' => '管理者一號',
                'has_admin' => true,
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'username' => 'admin2',
                'password' => Hash::make('admin123!@#'),
                'email' => 'b@a.a',
                'name' => '管理者二號',
                'has_admin' => false,
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'username' => 'admin3',
                'password' => Hash::make('admin123!@#'),
                'email' => 'a@b.a',
                'name' => '管理者三號',
                'has_admin' => false,
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ]
        );
        */
    }
}
