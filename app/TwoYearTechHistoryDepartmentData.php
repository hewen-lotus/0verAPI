<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\TwoYearTechHistoryDepartmentData
 *
 * @property int $history_id
 * @property string $id 系所代碼（系統按規則產生）
 * @property string $school_code 學校代碼
 * @property string $title 系所名稱
 * @property string $eng_title 系所英文名稱
 * @property string $description 選系說明
 * @property string $eng_description 選系英文說明
 * @property string $memo 給海聯的備註
 * @property string $eng_memo 給海聯的英文備註
 * @property string $url 系網站網址
 * @property string $eng_url 英文系網站網址
 * @property int $last_year_personal_apply_offer 去年個人申請錄取名額
 * @property int $last_year_personal_apply_amount 去年個人申請名額
 * @property int $admission_selection_quota 個人申請名額
 * @property bool $has_self_enrollment 是否有自招
 * @property int $self_enrollment_quota 自招名額
 * @property bool $has_special_class 是否招收僑生專班
 * @property string $approve_no_of_special_class 招收僑生專班核定文號
 * @property string $approval_doc_of_special_class 招收僑生專班核定公文電子檔(file path)
 * @property bool $has_foreign_special_class 是否招收外生專班
 * @property string $special_dept_type 特殊系所（醫、牙、中醫、藝術）
 * @property string $gender_limit 性別限制
 * @property int $admission_placement_ratify_quota 教育部核定聯合分發名額
 * @property int $admission_selection_ratify_quota 教育部核定個人申請名額
 * @property int $self_enrollment_ratify_quota 教育部核定單獨招收(自招)名額
 * @property int $rank 志願排名
 * @property int $sort_order 輸出排序
 * @property bool $has_birth_limit 是否限制出生日期
 * @property string $birth_limit_after 限…之後出生
 * @property string $birth_limit_before 限…之前出生
 * @property bool $has_review_fee 是否要收審查費用
 * @property string $review_fee_detail 審查費用細節
 * @property string $eng_review_fee_detail 審查費用英文細節
 * @property bool $has_eng_taught 全英文授課
 * @property bool $has_disabilities 是否招收身障學生
 * @property bool $has_BuHweiHwaWen 是否招收不具華文基礎學生
 * @property string $ip_address 按下送出的人的IP
 * @property string $info_status 資料狀態（editing|waiting|returned|confirmed
 * @property string $quota_status 名額狀態（editing|waiting|returned|confirmed
 * @property int $main_group 主要隸屬學群代碼
 * @property int $sub_group 次要隸屬學群代碼
 * @property int $evaluation 系所評鑑等級
 * @property string $review_memo 海聯審閱備註
 * @property string $review_by 海聯審閱人員
 * @property string $review_at 海聯審閱的時間點
 * @property string $created_by 此歷史紀錄建立者
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\SchoolData $confirmed
 * @property-read \App\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TwoYearTechDepartmentEditorPermission[] $editor_permission
 * @property-read \App\User $reviewer
 * @property-read \App\SchoolData $school
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereAdmissionPlacementRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereAdmissionSelectionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereAdmissionSelectionRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereApprovalDocOfSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereApproveNoOfSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereBirthLimitAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereBirthLimitBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereEngMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereEngReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereGenderLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHasBirthLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHasBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHasDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHasEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHasForeignSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHasReviewFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHasSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereInfoStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereLastYearPersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereLastYearPersonalApplyOffer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereMainGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereQuotaStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereReviewAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereReviewBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereReviewMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereSelfEnrollmentQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereSelfEnrollmentRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereSpecialDeptType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereSubGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereUrl($value)
 * @mixin \Eloquent
 * @property bool $has_RiJian 是否有招收日間二技學制
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData whereHasRiJian($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechHistoryDepartmentData withoutTrashed()
 */
class TwoYearTechHistoryDepartmentData extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'two_year_tech_department_history_data';

    protected $dateFormat = Carbon::ISO8601;

    protected $casts = [
        'id' => 'string',
        'has_self_enrollment' => 'boolean',
        'has_special_class' => 'boolean',
        'has_foreign_special_class' => 'boolean',
        'has_birth_limit' => 'boolean',
        'has_eng_taught' => 'boolean',
        'has_disabilities' => 'boolean',
        'has_BuHweiHwaWen' => 'boolean',
        'has_RiJian' => 'boolean'
    ];

    protected $fillable = [
        'id', //系所代碼（系統按規則產生）
        'school_code', //學校代碼
        'title', //系所名稱
        'eng_title', //系所英文名稱
        'description', //選系說明
        'eng_description', //選系英文說明
        'memo', //給海聯的備註
        'url', //系網站網址
        'eng_url', //英文系網站網址
        'last_year_personal_apply_offer', //去年個人申請錄取名額
        'last_year_personal_apply_amount', //去年個人申請名額
        'admission_selection_quota', //個人申請名額
        'has_self_enrollment', //是否有自招
        'self_enrollment_quota', //自招名額
        'has_special_class', //是否招收僑生專班
        'approve_no_of_special_class', //招收僑生專班核定文號
        'approval_doc_of_special_class', //招收僑生專班核定公文電子檔(file path)
        'has_foreign_special_class', //是否招收外生專班
        'special_dept_type', //特殊系所（醫、牙、中醫、藝術）
        'gender_limit', //性別限制
        //'admission_placement_ratify_quota', //教育部核定聯合分發名額
        //'admission_selection_ratify_quota', //教育部核定個人申請名額
        //'self_enrollment_ratify_quota', //教育部核定單獨招收(自招)名額
        'sort_order', //輸出排序
        'has_review_fee', //是否另外收取審查費用
        'review_fee_detail', //審查費用說明
        'eng_review_fee_detail', //審查費用英文說明
        'has_birth_limit', //是否限制出生日期
        'birth_limit_after', //限…之後出生
        'birth_limit_before', //限…之前出生
        'main_group', //主要隸屬學群代碼
        'sub_group', //次要隸屬學群代碼
        'has_eng_taught', //全英文授課
        'has_disabilities', //是否招收身障學生
        'has_BuHweiHwaWen', //是否招收不具華文基礎學生
        'has_RiJian', //是否有招收日間二技學制
        'evaluation', //系所評鑑等級
        'created_by', //按下送出的人是誰
        'ip_address', //按下送出的人的IP
        'info_status', //waiting|confirmed|editing|returned
        'quota_status', //waiting|confirmed|editing|returned
        'review_memo', //讓學校再次修改的原因
        'review_by', //海聯回覆的人員
        'review_at', //海聯回覆的時間點
        'created_at', //此版本建立時間
    ];

    protected $dates = ['deleted_at'];

    public function school()
    {
        return $this->belongsTo('App\SchoolData', 'school_code', 'id');
    }

    public function editor_permission()
    {
        return $this->hasMany('App\TwoYearTechDepartmentEditorPermission', 'dept_id', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo('App\User', 'review_by', 'username');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'username');
    }

    public function confirmed()
    {
        return $this->hasOne('App\SchoolData', 'history_id', 'history_id');
    }
}
