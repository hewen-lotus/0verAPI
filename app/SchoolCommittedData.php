<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SchoolCommittedData
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
 * @property string $committed_by 按下儲存的人是誰
 * @property string $ip_address 按下儲存的人的IP
 * @property string $review_status waiting|confirmed|editing
 * @property string $reason 讓學校再次修改的原因
 * @property string $replied_by 海聯回覆的人員
 * @property string $replied_at 海聯回覆的時間點
 * @property string $confirmed_by 海聯審查的人員
 * @property string $confirmed_at 海聯審查的時間點
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereApprovalDocumentOfIndependentRecruitment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereApproveNoOfIndependentRecruitment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereCommittedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereConfirmedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereConfirmedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereDormInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereEngAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereEngDormInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereEngOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereEngScholarshipDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereEngScholarshipUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereFiveYearAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereFiveYearRule($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereRepliedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereRepliedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereReviewStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereScholarship($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereScholarshipDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereScholarshipUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereSelfLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolCommittedData whereUrl($value)
 * @mixin \Eloquent
 */
class SchoolCommittedData extends Model
{
    use SoftDeletes;

    protected $table = 'school_committed_data';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'id', //學校代碼
        'saved_id', //對應 saved 表的 id
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
        'approve_no_of_self_enrollment', //[自招]核定文號
        'approval_doc_of_self_enrollment', //[自招]核定公文電子檔(file path)
        'committed_by', //按下送出的人是誰
        'ip_address', //按下送出的人的IP
        'review_status', //waiting|confirmed|editing
        'review_memo', //讓學校再次修改的原因
        'replied_by', //海聯回覆的人員
        'replied_at', //海聯回覆的時間點
        'confirmed_by', //海聯審查的人員
        'confirmed_at', //海聯審查的時間點
    ];

    protected $dates = ['deleted_at'];
}
