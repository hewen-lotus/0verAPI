<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DepartmentGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('department_groups')->insert([
            ['title' => '資訊學群','eng_title' => 'Information Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '工程學群','eng_title' => 'Engineering Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '數理化學群','eng_title' => 'Mathematics, Physics and Chemistry Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '醫藥衛生學群','eng_title' => 'Medical Health Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '生命科學學群','eng_title' => 'Life Science Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '生物資源學群','eng_title' => 'Agriculture, Forestry, Fishery and Husbandry Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '地球與環境學群','eng_title' => 'Earth and Environment Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '外語學群','eng_title' => 'Foreign Language Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '文史哲學群','eng_title' => 'Literature, History and Philosophy Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '教育學群','eng_title' => 'Education Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '法政學群','eng_title' => 'Law and Politics Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '管理學群','eng_title' => 'Management Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '財經學群','eng_title' => 'Finance and Economics Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '社會與心理學群','eng_title' => 'Social and Psychology Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '大眾傳播學群','eng_title' => 'Mass Communication Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '建築與設計學群','eng_title' => 'Architecture and Design Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '藝術學群','eng_title' => 'Fine Art Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['title' => '遊憩與運動學群','eng_title' => 'Physical Education and Leisure Group','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
        ]);
    }
}
