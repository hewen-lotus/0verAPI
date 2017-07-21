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
            ['name' => '最高學歷證明','eng_name' => 'Proof of highest education','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '高中在校歷年成績單正本','eng_name' => 'Original copy of the senior high school annual transcript','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文自傳','eng_name' => 'Biography in Chinese','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文自傳','eng_name' => 'Biography in English','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文讀書計畫書','eng_name' => 'Study Plan in Chinese','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文讀書計畫書','eng_name' => 'Study Plan in English','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '學習研究計劃書','eng_name' => 'Study Plan and Research Proposal','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '師長推薦函','eng_name' => 'Recommendation letter(s) from teachers','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文能力說明或相關證明文件','eng_name' => 'Certificate or relevant documents of Chinese language proficiency','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文能力說明或相關證明文件','eng_name' => 'Certificate or relevant documents of English language proficiency','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '華文證明HSK3或TOCFL Level2','eng_name' => 'Chinese language HSK3 or TOCFL Level 2 certificate','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '單一學系審查費繳費證明','eng_name' => 'Proof of payment of the single department review fee','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '參展證明、社團參與證明、學生幹部證明、校內外服務證明','eng_name' => 'Proof of participation in exhibitions, proof of membership of clubs and societies, service certificate of student committee member, certificate of on/off-campus service','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '技(藝)能競賽得獎證明','eng_name' => 'Award certificate received from skills (talent) competitions','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '專題成果作品(或特殊表現)證明','eng_name' => 'Proof of achievement of specialized works (or special performances)','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '相關證照或檢定證明','eng_name' => 'Other relevant licenses or certificates','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '其他有利審查之資料','eng_name' => 'Other documents that may benefit the review procedures','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '作品集','eng_name' => 'Collection','system_id' => '1','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],

            ['name' => '最高學歷證明','eng_name' => 'Proof of highest education','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '副學士或高級文憑在校歷年成績單正本','eng_name' => 'Original copy of diploma of associate degree or higher diploma annual transcript','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文自傳','eng_name' => 'Biography in Chinese','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文自傳','eng_name' => 'Biography in English','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文讀書計畫書','eng_name' => 'Study Plan in Chinese','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文讀書計畫書','eng_name' => 'Study Plan in English','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '學習研究計劃書','eng_name' => 'Study Plan and Research Proposal','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '師長推薦函','eng_name' => 'Recommendation letter(s) from teachers','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文能力說明或相關證明文件','eng_name' => 'Certificate or relevant documents of Chinese language proficiency','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文能力說明或相關證明文件','eng_name' => 'Certificate or relevant documents of English language proficiency','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '華文證明HSK3或TOCFL Level2','eng_name' => 'Chinese language HSK3 or TOCFL Level 2 certificate','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '單一學系審查費繳費證明','eng_name' => 'Proof of payment of the single department review fee','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '參展證明、社團參與證明、學生幹部證明、校內外服務證明','eng_name' => 'Proof of participation in exhibitions, proof of membership of clubs and societies, service certificate of student committee member, certificate of on/off-campus service','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '技(藝)能競賽得獎證明','eng_name' => 'Award certificate received from skills (talent) competitions','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '專題成果作品(或特殊表現)證明','eng_name' => 'Proof of achievement of specialized works (or special performances)','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '其他有利審查之資料','eng_name' => 'Other documents that may benefit the review procedures','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '學術著作','eng_name' => 'Academic publications','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '進修計畫書','eng_name' => 'Short-term study proposal','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '相關證照或檢定證明','eng_name' => 'Other relevant licenses or certificates','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '作品集','eng_name' => 'Collection','system_id' => '2','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],

            ['name' => '最高學歷證明','eng_name' => 'Proof of highest education','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '大學歷年成績單正本','eng_name' => 'Original copy of the Past years’ university transcripts','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文自傳','eng_name' => 'Biography in Chinese','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文自傳','eng_name' => 'Biography in English','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文讀書計畫書','eng_name' => 'Study Plan in Chinese','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文讀書計畫書','eng_name' => 'Study Plan in English','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '學習研究計劃書','eng_name' => 'Study Plan and Research Proposal','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '師長推薦函','eng_name' => 'Recommendation letter(s) from teachers','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文能力說明或相關證明文件','eng_name' => 'Certificate or relevant documents of Chinese language proficiency','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文能力說明或相關證明文件','eng_name' => 'Certificate or relevant documents of English language proficiency','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '華文證明HSK3或TOCFL Level2','eng_name' => 'Chinese language HSK3 or TOCFL Level 2 certificate','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '單一學系審查費繳費證明','eng_name' => 'Proof of payment of the single department review fee','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '參展證明、社團參與證明、學生幹部證明、校內外服務證明','eng_name' => 'Proof of participation in exhibitions, proof of membership of clubs and societies, service certificate of student committee member, certificate of on/off-campus service','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '技(藝)能競賽得獎證明','eng_name' => 'Award certificate received from skills (talent) competitions','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '專題成果作品(或特殊表現)證明','eng_name' => 'Proof of achievement of specialized works (or special performances)','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '其他有利審查之資料','eng_name' => 'Other documents that may benefit the review procedures','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '學術著作','eng_name' => 'Academic publications','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '進修計畫書','eng_name' => 'Short-term study proposal','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '相關證照或檢定證明','eng_name' => 'Other relevant licenses or certificates','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '作品集','eng_name' => 'Collection','system_id' => '3','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],

            ['name' => '最高學歷證明','eng_name' => 'Proof of highest education','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '碩士班歷年成績單正本','eng_name' => 'Original copy of the Past years’ Master’s program transcripts annual transcript','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文自傳','eng_name' => 'Biography in Chinese','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文自傳','eng_name' => 'Biography in English','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文讀書計畫書','eng_name' => 'Study Plan in Chinese','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文讀書計畫書','eng_name' => 'Study Plan in English','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '學習研究計劃書','eng_name' => 'Study Plan and Research Proposal','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '師長推薦函','eng_name' => 'Recommendation letter(s) from teachers','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '中文能力說明或相關證明文件','eng_name' => 'Certificate or relevant documents of Chinese language proficiency','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '英文能力說明或相關證明文件','eng_name' => 'Certificate or relevant documents of English language proficiency','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '華文證明HSK3或TOCFL Level2','eng_name' => 'Chinese language HSK3 or TOCFL Level 2 certificate','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '單一學系審查費繳費證明','eng_name' => 'Proof of payment of the single department review fee','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '參展證明、社團參與證明、學生幹部證明、校內外服務證明','eng_name' => 'Proof of participation in exhibitions, proof of membership of clubs and societies, service certificate of student committee member, certificate of on/off-campus service','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '技(藝)能競賽得獎證明','eng_name' => 'Award certificate received from skills (talent) competitions','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '專題成果作品(或特殊表現)證明','eng_name' => 'Proof of achievement of specialized works (or special performances)','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '其他有利審查之資料','eng_name' => 'Other documents that may benefit the review procedures','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '學術著作','eng_name' => 'Academic publications','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '進修計畫書','eng_name' => 'Short-term study proposal','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '相關證照或檢定證明','eng_name' => 'Other relevant licenses or certificates','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
            ['name' => '作品集','eng_name' => 'Collection','system_id' => '4','created_at' => Carbon::now()->toIso8601String(),'updated_at' => Carbon::now()->toIso8601String()],
        ]);
    }
}
