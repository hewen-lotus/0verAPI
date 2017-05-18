<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\DepartmentData
 *
 * @property int $id 系所代碼（系統按規則產生）
 * @property string $school_code 學校代碼
 * @property string $card_code 讀卡代碼
 * @property string $title 系所名稱
 * @property string $eng_title 系所英文名稱
 * @property string $choice_memo 選系說明
 * @property string $eng_choice_memo 選系英文說明
 * @property string $doc_memo 書審說明
 * @property string $eng_doc_memo 書審英文說明
 * @property string $dept_memo 備註
 * @property string $eng_dept_memo 英文備註
 * @property string $url 系網站網址
 * @property string $eng_url 英文系網站網址
 * @property int $last_year_offer 去年聯合分發錄取名額
 * @property int $last_year_amount 去年聯合分發名額（只有學士班有聯合分發）
 * @property int $amount 聯合分發名額（只有學士班有聯合分發）
 * @property string $decrease_reason 減招原因
 * @property int $last_year_personal_apply_offer 去年個人申請錄取名額
 * @property int $last_year_personal_apply_amount 去年個人申請名額
 * @property int $personal_apply_amount 個人申請名額
 * @property bool $self_recurit 是否有自招
 * @property int $self_recurit_amount 自招名額
 * @property bool $special_class 是否招收僑生專班
 * @property bool $special_class_foriegn 是否招收外生專班
 * @property string $special_dept 特殊系所（醫、牙、中醫、藝術）
 * @property string $sex_limit 性別限制
 * @property int $ratify 核定名額
 * @property int $rank 志願排名
 * @property int $sort_order 輸出排序
 * @property string $after_birth 限…之後出生
 * @property string $before_birth 限…之前出生
 * @property string $dept_group 18大學群代碼
 * @property string $sub_dept_group 次要18大學群代碼
 * @property bool $eng_taught 全英文授課
 * @property bool $disabilities 是否招收身障學生
 * @property bool $BuHweiHwaWen 是否招收不具華文基礎學生
 * @property string $evaluation 系所評鑑等級
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\SchoolData $school
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereAfterBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereBeforeBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereCardCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereChoiceMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereDecreaseReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereDeptGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereDeptMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereDocMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngChoiceMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngDeptMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngDocMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereLastYearAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereLastYearOffer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereLastYearPersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereLastYearPersonalApplyOffer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData wherePersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereRatify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSelfRecurit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSelfRecuritAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSexLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSpecialClassForiegn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSpecialDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereSubDeptGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentData whereUrl($value)
 * @mixin \Eloquent
 * @property int $history_id
 * @property string $description 選系說明
 * @property string $eng_description 選系英文說明
 * @property string $memo 給海聯的備註
 * @property string $eng_memo 給海聯的英文備註
 * @property int $last_year_admission_placement_amount 去年聯合分發錄取名額
 * @property int $last_year_admission_placement_quota 去年聯合分發名額（只有學士班有聯合分發）
 * @property int $admission_placement_quota 聯合分發名額（只有學士班有聯合分發）
 * @property string $decrease_reason_of_admission_placement 聯合分發人數減招原因
 * @property int $admission_selection_quota 個人申請名額
 * @property bool $has_self_enrollment 是否有自招
 * @property int $self_enrollment_quota 自招名額
 * @property bool $has_special_class 是否招收僑生專班
 * @property bool $has_foreign_special_class 是否招收外生專班
 * @property string $special_dept_type 特殊系所（醫、牙、中醫、藝術）
 * @property string $gender_limit 性別限制
 * @property int $admission_placement_ratify_quota 教育部核定聯合分發名額
 * @property int $admission_selection_ratify_quota 教育部核定個人申請名額
 * @property bool $has_birth_limit 是否限制出生日期
 * @property string $birth_limit_after 限…之後出生
 * @property string $birth_limit_before 限…之前出生
 * @property int $main_group 主要隸屬學群代碼
 * @property int $sub_group 次要隸屬學群代碼
 * @property bool $has_eng_taught 全英文授課
 * @property bool $has_disabilities 是否招收身障學生
 * @property bool $has_BuHweiHwaWen 是否招收不具華文基礎學生
 * @property string $modified_by 儲存資料的人是誰
 * @property string $quantity_modified_by 儲存名額的人是誰
 * @property string $ip_address 按下儲存的人的IP
 * @property bool $has_review_fee 是否要收審查費用
 * @property string $review_fee_detail 審查費用細節
 * @property string $eng_review_fee_detail 審查費用英文細節
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereAdmissionPlacementQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereAdmissionPlacementRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereAdmissionSelectionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereAdmissionSelectionRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereBirthLimitAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereBirthLimitBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereDecreaseReasonOfAdmissionPlacement($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereEngMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereEngReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereGenderLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereHasBirthLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereHasBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereHasDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereHasEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereHasForeignSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereHasReviewFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereHasSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereLastYearAdmissionPlacementAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereLastYearAdmissionPlacementQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereMainGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereModifiedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereQuantityModifiedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereSelfEnrollmentQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereSpecialDeptType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedData whereSubGroup($value)
 */
class DepartmentSavedData extends Model
{
    use SoftDeletes;

    protected $table = 'department_saved_data';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'id', //系所代碼（系統按規則產生）
        'school_code', //學校代碼
        'card_code', //讀卡代碼
        'title', //系所名稱
        'eng_title', //系所英文名稱
        'description', //選系說明
        'eng_description', //選系英文說明
        'memo', //給海聯的備註
        'eng_memo', //給海聯的英文備註
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
        'admission_placement_ratify_quota', //教育部核定聯合分發名額
        'admission_selection_ratify_quota', //教育部核定個人申請名額
        'rank', //志願排名
        'sort_order', //輸出排序
        'has_birth_limit', //是否限制出生日期
        'birth_limit_after', //限…之後出生
        'birth_limit_before', //限…之前出生
        'main_group', //主要隸屬學群代碼
        'sub_group', //次要隸屬學群代碼
        'has_eng_taught', //全英文授課
        'has_disabilities', //是否招收身障學生
        'has_BuHweiHwaWen', //是否招收不具華文基礎學生
        'evaluation', //系所評鑑等級
        'modified_by', //儲存資料的人是誰
        'quantity_modified_by', //儲存名額的人是誰
        'ip_address', //按下儲存的人的IP
    ];

    protected $dates = ['deleted_at'];

    public function school()
    {
        return $this->belongsTo('App\SchoolData', 'school_code', 'id');
    }
}
