<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\GraduateDepartmentHistoryData
 *
 * @property int $history_id
 * @property string $id 系所代碼（系統按規則產生）
 * @property string $school_code 學校代碼
 * @property string $title 系所名稱
 * @property string $eng_title 系所英文名稱
 * @property int $system_id 這是碩士班還是博士班 QQ
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
 * @property bool $has_foreign_special_class 是否招收外生專班
 * @property string $special_dept_type 特殊系所（醫學系、牙醫學系、中醫學系、藝術相關學系）
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GraduateDepartmentEditorPermission[] $editor_permission
 * @property-read \App\User $reviewer
 * @property-read \App\SchoolData $school
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereAdmissionPlacementRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereAdmissionSelectionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereAdmissionSelectionRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereBirthLimitAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereBirthLimitBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereEngMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereEngReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereGenderLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereHasBirthLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereHasBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereHasDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereHasEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereHasForeignSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereHasReviewFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereHasSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereInfoStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereLastYearPersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereLastYearPersonalApplyOffer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereMainGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereQuotaStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereReviewAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereReviewBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereReviewMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereSelfEnrollmentQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereSelfEnrollmentRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereSpecialDeptType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereSubGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereSystemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData whereUrl($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryData withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GraduateDepartmentHistoryApplicationDocument[] $application_docs
 * @property string $group_code 系所類組（1|2|3）
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryData whereGroupCode($value)
 */
class GraduateDepartmentHistoryData extends Model
{
    use SoftDeletes;

    protected $table = 'graduate_department_history_data';

    protected $primaryKey = 'history_id';

    protected $dates = ['deleted_at'];

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
        'has_review_fee' => 'boolean'
    ];

    protected $fillable = [
        'id', //系所代碼（系統按規則產生）
        'school_code', //學校代碼
        'title', //系所名稱
        'eng_title', //系所英文名稱
        'system_id', //這是碩士班還是博士班 QQ
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
        'group_code', //類組
        'has_eng_taught', //全英文授課
        'has_disabilities', //是否招收身障學生
        'has_BuHweiHwaWen', //是否招收不具華文基礎學生
        'evaluation', //系所評鑑等級
        'created_by', //按下送出的人是誰
        'ip_address', //按下送出的人的IP
        'created_at', //此版本建立時間
    ];


    public function school()
    {
        return $this->belongsTo('App\SchoolHistoryData', 'school_code', 'id')->latest()->first();
    }

    public function editor_permission()
    {
        return $this->hasMany('App\GraduateDepartmentEditorPermission', 'dept_id', 'id');
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
        return $this->hasMany('App\GraduateDepartmentHistoryApplicationDocument', 'history_id', 'history_id');
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
}

