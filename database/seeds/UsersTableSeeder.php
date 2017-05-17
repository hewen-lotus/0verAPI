<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'admin1',
                'password' => Hash::make('admin123!@#'),
                'email' => 'a@a.a',
                'name' => '管理者一號',
                'eng_name' => 'admin1',
                'phone' => '0912345678',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'username' => 'admin2',
                'password' => Hash::make('admin123!@#'),
                'email' => 'b@a.a',
                'name' => '管理者二號',
                'eng_name' => 'admin2',
                'phone' => '0912345678',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'username' => 'admin3',
                'password' => Hash::make('admin123!@#'),
                'email' => 'a@b.a',
                'name' => '管理者三號',
                'eng_name' => 'admin2',
                'phone' => '0912345678',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'username' => 'editor1',
                'password' => Hash::make('admin123!@#'),
                'email' => 'a@a.a',
                'name' => 'A編輯',
                'eng_name' => 'english_name',
                'phone' => '0912345678',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'username' => 'editor2',
                'password' => Hash::make('admin123!@#'),
                'email' => 'b@a.a',
                'name' => 'B編輯',
                'eng_name' => 'english_name',
                'phone' => '0912345678',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],

            [
                'username' => 'editor3',
                'password' => Hash::make('admin123!@#'),
                'email' => 'c@a.a',
                'name' => 'C編輯',
                'eng_name' => 'english_name',
                'phone' => '0912345678',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ]
        ]);
    }
}
