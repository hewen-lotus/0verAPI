<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class SystemTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_types')->insert([
            [
                'type' => '學士學制',
                'eng_type' => '還沒想到'
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'type' => '二技學制',
                'eng_type' => '還沒想到'
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'type' => '碩士學制',
                'eng_type' => '還沒想到'
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'type' => '博士學制',
                'eng_type' => '還沒想到'
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ]
        ]);
    }
}
