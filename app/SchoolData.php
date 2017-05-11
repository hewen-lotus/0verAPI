<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SchoolData
 *
 * @property string $id 學校代碼
 * @property string $title 學校名稱
 * @property string $eng_title 學校英文名稱
 * @property string $address 學校地址
 * @property string $eng_address 學校英文地址
 * @property string $organization 學校負責僑生事務的承辦單位名稱
 * @property string $eng_organization 學校負責僑生事務的承辦單位英文名稱
 * @property string $dorm_info 宿舍說明
 * @property string $eng_dorm_info 宿舍英文說明
 * @property string $url 學校網站網址
 * @property string $eng_url 學校英文網站網址
 * @property string $type 「公、私立」與「大學、科大」之組合＋「僑先部」共五種
 * @property string $phone 學校聯絡電話（+886-49-2910960#1234）
 * @property string $fax 學校聯絡電話（+886-49-2910960#1234）
 * @property int $sort_order 學校顯示排序（教育部給）
 * @property bool $scholarship 是否提供僑生專屬獎學金
 * @property string $scholarship_url 僑生專屬獎學金說明網址
 * @property string $eng_scholarship_url 僑生專屬獎學金英文說明網址
 * @property string $scholarship_dept 獎學金負責單位名稱
 * @property string $eng_scholarship_dept 獎學金負責單位英文名稱
 * @property bool $five_year_allowed [中五]我可以招呢
 * @property bool $five_year_prepare [中五]我準備招了喔
 * @property string $five_year_confirmed_by [中五]誰說確定可以招的？(admin.username)
 * @property string $five_year_rule [中五]給海聯看的學則
 * @property string $approve_no 自招核定文號
 * @property int $self_limit 自招總額
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DepartmentData[] $departments
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereApproveNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereDormInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereEngAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereEngDormInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereEngOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereEngScholarshipDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereEngScholarshipUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereFiveYearAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereFiveYearConfirmedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereFiveYearPrepare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereFiveYearRule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereScholarship($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereScholarshipDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereScholarshipUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereSelfLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereUrl($value)
 * @mixin \Eloquent
 */
class SchoolData extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'school_data';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
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
        'approve_no_of_independent_recruitment', //自招核定文號
        'approval_document_of_independent_recruitment', //自招核定公文電子檔
        'self_limit', //自招總額
    ];

    protected $dates = ['deleted_at'];

    public function departments()
    {
        return $this->hasMany('App\DepartmentData', 'school_code', 'id');
    }

    //public function school_users()
    //{
    //    return $this->hasMany('App\SchoolUser', 'school_code', 'id');
    //}
}
