<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\DepartmentHistoryData
 *
 * @property int $history_id
 * @property int $id 系所代碼（系統按規則產生）
 * @property string $action
 * @property string $school_code 學校代碼
 * @property string $card_code 讀卡代碼
 * @property string $title 系所名稱
 * @property string $eng_title 系所英文名稱
 * @property string $description 選系說明
 * @property string $eng_description 選系英文說明
 * @property string $memo 給海聯的備註
 * @property string $eng_memo 給海聯的英文備註
 * @property string $url 系網站網址
 * @property string $eng_url 英文系網站網址
 * @property int $last_year_admission_placement_amount 去年聯合分發錄取名額
 * @property int $last_year_admission_placement_quota 去年聯合分發名額（只有學士班有聯合分發）
 * @property int $admission_placement_quota 聯合分發名額（只有學士班有聯合分發）
 * @property string $decrease_reason_of_admission_placement 聯合分發人數減招原因
 * @property int $last_year_personal_apply_offer 去年個人申請錄取名額
 * @property int $last_year_personal_apply_amount 去年個人申請名額
 * @property int $admission_selection_quota 個人申請名額
 * @property bool $has_self_enrollment 是否有自招
 * @property int $self_enrollment_quota 自招名額
 * @property bool $has_special_class 是否招收僑生專班
 * @property bool $has_foreign_special_class 是否招收外生專班
 * @property string $special_dept_type 特殊系所（醫、牙、中醫、藝術）
 * @property string $gender_limit 性別限制
 * @property int $admission_placement_ratify_quota 教育部核定聯合分發名額
 * @property int $admission_selection_ratify_quota 教育部核定個人申請名額
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
 * @property int $main_group 主要隸屬學群代碼
 * @property int $sub_group 次要隸屬學群代碼
 * @property int $evaluation 系所評鑑等級
 * @property string $ip_address 按下送出的人的IP
 * @property string $info_status 資料狀態（editing|waiting|returned|confirmed
 * @property string $quota_status 名額狀態（editing|waiting|returned|confirmed
 * @property string $review_memo 海聯審閱備註
 * @property string $review_by 海聯審閱人員
 * @property string $review_at 海聯審閱的時間點
 * @property string $created_by 此歷史紀錄建立者
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\SchoolData $confirmed
 * @property-read \App\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DepartmentEditorPermission[] $editor_permission
 * @property-read \App\User $reviewer
 * @property-read \App\SchoolData $school
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereAdmissionPlacementQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereAdmissionPlacementRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereAdmissionSelectionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereAdmissionSelectionRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereBirthLimitAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereBirthLimitBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereCardCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereDecreaseReasonOfAdmissionPlacement($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereEngMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereEngReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereGenderLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereHasBirthLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereHasBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereHasDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereHasEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereHasForeignSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereHasReviewFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereHasSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereInfoStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereLastYearAdmissionPlacementAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereLastYearAdmissionPlacementQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereLastYearPersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereLastYearPersonalApplyOffer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereMainGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereQuotaStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereReviewAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereReviewBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereReviewMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereSelfEnrollmentQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereSpecialDeptType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereSubGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereUrl($value)
 * @mixin \Eloquent
 * @property int $self_enrollment_ratify_quota 教育部核定單獨招收(自招)名額
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryData whereSelfEnrollmentRatifyQuota($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DepartmentHistoryApplicationDocument[] $application_docs
 */
class DepartmentHistoryData extends Model
{
    use SoftDeletes;

    protected $table = 'department_history_data';

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'string',
        'has_self_enrollment' => 'boolean',
        'has_special_class' => 'boolean',
        'has_foreign_special_class' => 'boolean',
        'has_birth_limit' => 'boolean',
        'has_eng_taught' => 'boolean',
        'has_disabilities' => 'boolean',
        'has_BuHweiHwaWen' => 'boolean'
    ];

    protected $fillable = [
        'id', //系所代碼（系統按規則產生）
        'school_code', //學校代碼
        'card_code', //讀卡代碼
        'title', //系所名稱
        'eng_title', //系所英文名稱
        'description', //選系說明
        'eng_description', //選系英文說明
        'url', //系網站網址
        'eng_url', //英文系網站網址
        'last_year_admission_placement_amount', //去年聯合分發錄取名額
        'last_year_admission_placement_quota', //去年聯合分發名額（只有學士班有聯合分發）
        'admission_placement_quota', //聯合分發名額（只有學士班有聯合分發）
        'decrease_reason_of_admission_placement', //聯合分發人數減招原因
        'last_year_personal_apply_offer', //去年個人申請錄取名額
        'last_year_personal_apply_amount', //'去年個人申請名額
        'admission_selection_quota', //個人申請名額
        'has_self_enrollment', //是否有自招
        'self_enrollment_quota', //自招名額
        'has_special_class', //是否招收僑生專班
        'has_foreign_special_class', //是否招收外生專班
        'special_dept_type', //特殊系所（醫、牙、中醫、藝術）
        'gender_limit', //性別限制
        //'admission_placement_ratify_quota', //教育部核定聯合分發名額
        //'admission_selection_ratify_quota', //教育部核定個人申請名額
        'rank', //志願排名
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
        'evaluation', //系所評鑑等級
        'ip_address', //ip_address
        'created_by', //created_by
    ];


    public function school()
    {
        return $this->belongsTo('App\SchoolData', 'school_code', 'id');
    }

    public function editor_permission()
    {
        return $this->hasMany('App\DepartmentEditorPermission', 'dept_id', 'id');
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

    public function application_docs() {
        return $this->hasMany('App\DepartmentHistoryApplicationDocument', 'history_id', 'history_id');
    }
}
