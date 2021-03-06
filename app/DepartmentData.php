<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\DepartmentData
 *
 * @mixin \Eloquent
 * @property int $id 系所代碼（系統按規則產生）
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
 * @property string $special_dept_type 特殊系所（醫學系、牙醫學系、中醫學系、藝術相關學系）
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
 * @property string $confirmed_by 資料由哪位海聯人員確認匯入的
 * @property string $confirmed_at 資料確認匯入的時間
 * @property \Carbon\Carbon $created_at
 * @property string $updated_by 資料最後更新者
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property int $history_id 從哪一筆歷史紀錄匯入的
 * @property-read \App\SchoolData $confirmed
 * @property-read \App\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DepartmentEditorPermission[] $editor_permission
 * @property-read \App\User $reviewer
 * @property-read \App\SchoolData $school
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereAdmissionPlacementQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereAdmissionPlacementRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereAdmissionSelectionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereAdmissionSelectionRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereBirthLimitAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereBirthLimitBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereCardCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereConfirmedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereConfirmedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereDecreaseReasonOfAdmissionPlacement($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereGenderLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereHasBirthLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereHasBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereHasDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereHasEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereHasForeignSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereHasReviewFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereHasSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereLastYearAdmissionPlacementAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereLastYearAdmissionPlacementQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereLastYearPersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereLastYearPersonalApplyOffer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereMainGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSelfEnrollmentQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSpecialDeptType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSubGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereUrl($value)
 * @property int $self_enrollment_ratify_quota 教育部核定單獨招收(自招)名額
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSelfEnrollmentRatifyQuota($value)
 * @property-read \App\EvaluationLevel $evaluation_level
 * @property-read \App\DepartmentGroup $main_group_data
 * @property-read \App\DepartmentGroup $sub_group_data
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DepartmentApplicationDocument[] $application_doc
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData withoutTrashed()
 * @property string $group_code 系所類組（1|2|3）
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentData whereGroupCode($value)
 * @property-read \App\AdmissionPlacementStepQuota $admission_placement_step_quota
 * @property bool $use_eng_data 本年度是否提供英文資料
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DepartmentData whereUseEngData($value)
 */
class DepartmentData extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'department_data';

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
        'has_BuHweiHwaWen' => 'boolean',
        'has_review_fee' => 'boolean',
        'use_eng_data' => 'boolean'
    ];

    protected $fillable = [
        'history_id', //從哪一筆歷史紀錄匯入的
        'updated_by', //資料最後更新者
        'confirmed_by', //資料由哪位海聯人員確認匯入的
        'confirmed_at',
        'id', //系所代碼（系統按規則產生）
        'school_code', //學校代碼
        'card_code', //讀卡代碼
        'title', //系所名稱
        'eng_title', //系所英文名稱
        'description', //選系說明
        'eng_description', //選系英文說明
        'memo', //給海聯的備註
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
        'group_code', //類組
        'has_eng_taught', //全英文授課
        'has_disabilities', //是否招收身障學生
        'has_BuHweiHwaWen', //是否招收不具華文基礎學生
        'evaluation', //系所評鑑等級
        'use_eng_data', //本年度是否提供英文資料
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

    public function evaluation_level()
    {
        return $this->belongsTo('App\EvaluationLevel', 'evaluation', 'id');
    }

    public function main_group_data()
    {
        return $this->belongsTo('App\DepartmentGroup', 'main_group', 'id');
    }

    public function sub_group_data()
    {
        return $this->belongsTo('App\DepartmentGroup', 'sub_group', 'id');
    }

    public function application_doc()
    {
        return $this->hasMany('App\DepartmentApplicationDocument', 'dept_id', 'id');
    }

    public function admission_placement_step_quota()
    {
        return $this->hasOne('App\AdmissionPlacementStepQuota', 'dept_id', 'id');
    }
}
