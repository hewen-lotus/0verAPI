<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class SchoolData extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'school_data';

    protected $dateFormat = Carbon::ISO8601;

    protected $casts = [
        'has_dorm' => 'boolean',
        'has_scholarship' => 'boolean',
        'has_five_year_student_allowed' => 'boolean',
        'has_self_enrollment' => 'boolean',
        'url' => 'string'
    ];

    protected $fillable = [
        'id', //學校代碼
        'history_id', //從哪一筆歷史紀錄匯入的
        'updated_by', //資料最後更新者
        'deleted_by', //資料由哪位海聯人員確認匯入的
        'title', //學校名稱
        'eng_title', //學校英文名稱
        'address', //學校地址
        'eng_address', //學校英文地址
        'organization', //學校負責僑生事務的承辦單位名稱
        'eng_organization', //學校負責僑生事務的承辦單位英文名稱
        'has_dorm', //是否提供宿舍
        'dorm_info', //宿舍說明
        'eng_dorm_info', //宿舍英文說明
        'url', //學校網站網址
        'eng_url', //學校英文網站網址
        'type', //「公、私立」與「大學、科大」之組合＋「僑先部」共五種
        'phone', //學校聯絡電話（+886-49-2910960#1234）
        'fax', //學校聯絡電話（+886-49-2910960#1234）
        'sort_order', //學校顯示排序（教育部給）
        'has_scholarship', //是否提供僑生專屬獎學金
        'scholarship_url', //僑生專屬獎學金說明網址
        'eng_scholarship_url', //僑生專屬獎學金英文說明網址
        'scholarship_dept', //獎學金負責單位名稱
        'eng_scholarship_dept', //獎學金負責單位英文名稱
        'has_five_year_student_allowed', //[中五]我可以招呢
        'rule_of_five_year_student', //[中五]給海聯看的學則
        'rule_doc_of_five_year_student', //[中五]學則文件電子擋(file path)
        'has_self_enrollment', //[自招]是否單獨招收僑生
        'approval_no_of_self_enrollment', //[自招]核定文號
        'approval_doc_of_self_enrollment', //[自招]核定公文電子檔(file path)
    ];

    protected $dates = ['deleted_at'];

    public function departments()
    {
        return $this->hasMany('App\DepartmentData', 'school_code', 'id');
    }

    public function graduate_departments()
    {
        return $this->hasMany('App\GraduateDepartmentData', 'school_code', 'id');
    }

    public function two_year_tech_departments()
    {
        return $this->hasMany('App\TwoYearTechDepartmentData', 'school_code', 'id');
    }

    public function systems()
    {
        return $this->hasMany('App\SystemData', 'school_code', 'id');
    }

    public function history()
    {
        return $this->belongsTo('App\SchoolHistoryData', 'history_id', 'history_id');
    }
}
