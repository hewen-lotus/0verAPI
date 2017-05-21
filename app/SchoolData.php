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
 * @property bool $has_dorm 是否提供宿舍
 * @property string $dorm_info 宿舍說明
 * @property string $eng_dorm_info 宿舍英文說明
 * @property string $url 學校網站網址
 * @property string $eng_url 學校英文網站網址
 * @property string $type 「公、私立」與「大學、科大」之組合＋「僑先部」共五種
 * @property string $phone 學校聯絡電話（+886-49-2910960#1234）
 * @property string $fax 學校聯絡電話（+886-49-2910960#1234）
 * @property int $sort_order 學校顯示排序（教育部給）
 * @property bool $has_scholarship 是否提供僑生專屬獎學金
 * @property string $scholarship_url 僑生專屬獎學金說明網址
 * @property string $eng_scholarship_url 僑生專屬獎學金英文說明網址
 * @property string $scholarship_dept 獎學金負責單位名稱
 * @property string $eng_scholarship_dept 獎學金負責單位英文名稱
 * @property bool $has_five_year_student_allowed [中五]我可以招呢
 * @property string $rule_of_five_year_student [中五]給海聯看的學則
 * @property string $rule_doc_of_five_year_student [中五]學則文件電子擋(file path)
 * @property bool $has_self_enrollment [自招]是否單獨招收僑生
 * @property string $approval_no_of_self_enrollment [自招]核定文號
 * @property string $approval_doc_of_self_enrollment [自招]核定公文電子檔(file path)
 * @property string $confirmed_by 資料由哪位海聯人員確認匯入的
 * @property string $confirmed_at 資料確認匯入的時間
 * @property \Carbon\Carbon $created_at
 * @property string $updated_by 資料最後更新者
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property int $history_id 從哪一筆歷史紀錄匯入的
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DepartmentData[] $departments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GraduateDepartmentData[] $graduate_department
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TwoYearTechDepartmentData[] $two_year_tech_department
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereApprovalDocOfSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereApprovalNoOfSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereConfirmedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereConfirmedBy($value)
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
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereHasDorm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereHasFiveYearStudentAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereHasScholarship($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereRuleDocOfFiveYearStudent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereRuleOfFiveYearStudent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereScholarshipDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereScholarshipUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolData whereUrl($value)
 * @mixin \Eloquent
 */
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

    public function graduate_department()
    {
        return $this->hasMany('App\GraduateDepartmentData', 'school_code', 'id');
    }

    public function two_year_tech_department()
    {
        return $this->hasMany('App\TwoYearTechDepartmentData', 'school_code', 'id');
    }
}
