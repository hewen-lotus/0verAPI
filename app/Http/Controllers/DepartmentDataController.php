<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;
use DB;

use App\DepartmentData;
use App\DepartmentSavedData;
use App\DepartmentCommittedData;

class DepartmentDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->admin != NULL) {
            return DepartmentData::all();
        }

        return DepartmentData::where('id', '=', $user->school_editor->school_code)->first();
    }

    public function show(Request $request, $school_id)
    {
        if (SchoolData::where('id', '=', $school_id)->exists()) {
            return SchoolData::where('id', '=', $school_id)->with('departments')->first();
        }

        $messages = array('School Data Not Found!');

        return response()->json(compact('messages'), 404);
    }

    /*
    'id', //系所代碼（系統按規則產生）
    'school_code', //學校代碼
    'card_code', //讀卡代碼
    'title', //系所名稱
    'eng_title', //系所英文名稱
    'choice_memo', //選系說明
    'eng_choice_memo', //選系英文說明
    'doc_memo', //書審說明
    'eng_doc_memo', //書審英文說明
    'dept_memo', //備註
    'eng_dept_memo', //英文備註
    'url', //系網站網址
    'eng_url', //英文系網站網址
    'last_year_offer', //去年聯合分發錄取名額
    'decrease_reason', //減招原因
    'last_year_amount', //去年聯合分發名額（只有學士班有聯合分發）
    'amount', //聯合分發名額（只有學士班有聯合分發）
    'personal_apply_amount', //個人申請名額
    'last_year_personal_apply_amount', //去年個人申請名額
    'last_year_personal_apply_offer', //去年個人申請錄取名額
    'self_recurit', //是否有自招
    'self_recurit_amount', //自招名額
    'special_class', //是否招收僑生專班
    'special_class_foriegn', //是否招收外生專班
    'special_dept', //特殊系所（醫、牙、中醫、藝術）
    'sex_limit', //性別限制
    'ratify', //核定名額
    'rank', //志願排名
    'sortorder', //輸出排序
    'after_birth', //限…之後出生
    'before_birth', //限…之前出生
    'dept_group', //18大學群代碼
    'sub_dept_group', //次要18大學群代碼
    'eng_taught', //全英文授課
    'disabilities', //是否招收身障學生
    'BuHweiHwaWen', //是否招收不具華文基礎學生
    'evaluation', //系所評鑑等級
    */
}
