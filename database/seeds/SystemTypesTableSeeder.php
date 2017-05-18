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
                'title' => '學士學制',
                'eng_title' => 'Bachelor',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'title' => '二技學制',
                'eng_title' => 'Two-Year Technical',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'title' => '碩士學制',
                'eng_title' => 'Master',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ],
            [
                'title' => '博士學制',
                'eng_title' => 'PhD',
                'created_at' => Carbon::now()->toIso8601String(),
                'updated_at' => Carbon::now()->toIso8601String()
            ]
        ]);
    }
}
