<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SchoolSavedData
 *
 * @property int $history_id
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
 * @property string $five_year_rule [中五]給海聯看的學則
 * @property string $approve_no_of_independent_recruitment 自招核定文號
 * @property string $approval_document_of_independent_recruitment 自招核定公文電子檔
 * @property int $self_limit 自招總額
 * @property string $modified_by 按下儲存的人是誰
 * @property string $ip_address 按下儲存的人的IP
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereApprovalDocumentOfIndependentRecruitment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereApproveNoOfIndependentRecruitment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereDormInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereEngAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereEngDormInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereEngOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereEngScholarshipDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereEngScholarshipUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereFiveYearAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereFiveYearRule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereModifiedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereScholarship($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereScholarshipDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereScholarshipUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereSelfLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolSavedData whereUrl($value)
 * @mixin \Eloquent
 */
class SchoolSavedData extends Model
{
    use SoftDeletes;

    protected $table = 'school_saved_data';

    protected $primaryKey = 'history_id';

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
        'five_year_rule', //[中五]給海聯看的學則
        'approve_no_of_independent_recruitment', //自招核定文號
        'approval_document_of_independent_recruitment', //自招核定公文電子檔(file path)
        'self_limit', //自招總額
        'modified_by', //按下儲存的人是誰
        'ip_address', //按下儲存的人的IP
    ];

    protected $dates = ['deleted_at'];
}
