<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\SchoolData;

class SchoolDataController extends Controller
{
    /**
     * 新增學校
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        'id', //學校代碼
        'title', //學校名稱
        'eng_title', //學校英文名稱
        'address', //學校地址
        'eng_address', //學校英文地址
        'organization', //學校負責僑生事務的承辦單位名稱
        'eng_organization', //學校負責僑生事務的承辦單位英文名稱
        'dorm_info', //宿舍說明
        'eng_dorm_info', //宿舍英文說明
        'url', //學校網站網址
        'eng_url', //學校英文網站網址
        'type', //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
        'phone', //學校聯絡電話（+886-49-2910960#1234）
        'fax', //學校聯絡電話（+886-49-2910960#1234）
        'sort_order', //學校顯示排序（教育部給）
        'scholarship', //是否提供僑生專屬獎學金
        'scholarship_url', //僑生專屬獎學金說明網址
        'eng_scholarship_url', //僑生專屬獎學金英文說明網址
        'scholarship_dept', //獎學金負責單位名稱
        'eng_scholarship_dept', //獎學金負責單位英文名稱
        'five_year_allowed', //[中五]我可以招呢
        'five_year_prepare', //[中五]我準備招了喔
        'five_year_confirmed_by', //[中五](school code)
        'five_year_rule', //[中五]給海聯看的學則
        'approve_no', //自招核定文號
        'self_limit', //自招總額
    }

    /**
     * 更新學校資訊
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $school_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $school_id)
    {

    }

    /**
     * 取得學校資訊（校名、介紹等）與所有系所資訊
     *
     * @param  int  $school_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $school_id)
    {

    }
}
