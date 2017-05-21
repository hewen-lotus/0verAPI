<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SchoolHistoryData
 *
 * @property int $history_id
 * @property string $id 學校代碼
 * @property string $action
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
 * @property string $ip_address 按下送出的人的IP
 * @property string $info_status 資料狀態（editing|waiting|returned|confirmed
 * @property string $review_memo 海聯審閱備註
 * @property string $review_by 海聯審閱人員
 * @property string $review_at 海聯審閱的時間點
 * @property string $created_by 此歷史紀錄建立者
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\User $creator
 * @property-read \App\Admin $reviewer
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereApprovalDocOfSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereApprovalNoOfSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereDormInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereEngAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereEngDormInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereEngOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereEngScholarshipDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereEngScholarshipUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereHasDorm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereHasFiveYearStudentAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereHasScholarship($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereInfoStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereReviewAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereReviewBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereReviewMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereRuleDocOfFiveYearStudent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereRuleOfFiveYearStudent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereScholarshipDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereScholarshipUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolHistoryData whereUrl($value)
 * @mixin \Eloquent
 */
class SchoolHistoryData extends Model
{
    use SoftDeletes;

    protected $table = 'school_history_data';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $casts = [
        'has_dorm' => 'boolean',
        'has_scholarship' => 'boolean',
        'has_five_year_student_allowed' => 'boolean',
        'has_self_enrollment' => 'boolean'
    ];

    protected $fillable = [
        'id', //學校代碼
        'action', // 儲存或送出
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
        'scholarship', //是否提供僑生專屬獎學金
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
        'created_by', //按下送出的人是誰
        'ip_address', //按下送出的人的IP
        'info_status', //waiting|confirmed|editing|returned
        'review_memo', //讓學校再次修改的原因
        'review_by', //海聯回覆的人員
        'review_at', //海聯回覆的時間點
    ];

    protected $dates = ['deleted_at'];

    public function reviewer()
    {
        return $this->belongsTo('App\User', 'review_by', 'username');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'username');
    }
}
