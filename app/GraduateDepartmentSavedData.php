<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\GraduateDepartmentData
 *
 * @property int $id 系所代碼（系統按規則產生）
 * @property string $school_code 學校代碼
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
 * @property int $last_year_personal_apply_offer 去年個人申請錄取名額
 * @property int $last_year_personal_apply_amount 去年個人申請名額
 * @property int $personal_apply_amount 個人申請名額
 * @property string $decrease_reason 減招原因
 * @property bool $self_recurit 是否有自招
 * @property int $self_recurit_amount 自招名額
 * @property bool $special_class 是否招收僑生專班
 * @property bool $special_class_foriegn 是否招收外生專班
 * @property string $special_dept 特殊系所（醫、牙、中醫、藝術）
 * @property string $sex_limit 性別限制
 * @property int $ratify 核定名額
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
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereAfterBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereBeforeBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereChoiceMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereDecreaseReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereDeptGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereDeptMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereDocMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereEngChoiceMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereEngDeptMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereEngDocMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereLastYearPersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereLastYearPersonalApplyOffer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData wherePersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereRatify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereSelfRecurit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereSelfRecuritAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereSexLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereSpecialClassForiegn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereSpecialDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereSubDeptGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentData whereUrl($value)
 * @mixin \Eloquent
 * @property int $history_id
 * @property string $description 選系說明
 * @property string $eng_description 選系英文說明
 * @property string $memo 給海聯的備註
 * @property string $eng_memo 給海聯的英文備註
 * @property int $admission_selection_quota 個人申請名額
 * @property bool $has_self_enrollment 是否有自招
 * @property int $self_enrollment_quota 自招名額
 * @property bool $has_special_class 是否招收僑生專班
 * @property bool $has_foreign_special_class 是否招收外生專班
 * @property string $special_dept_type 特殊系所（醫、牙、中醫、藝術）
 * @property string $gender_limit 性別限制
 * @property int $admission_placement_ratify_quota 教育部核定聯合分發名額
 * @property int $admission_selection_ratify_quota 教育部核定個人申請名額
 * @property int $self_enrollment_ratify_quota 教育部核定單獨招收(自招)名額
 * @property int $rank 志願排名
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
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereAdmissionPlacementRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereAdmissionSelectionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereAdmissionSelectionRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereBirthLimitAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereBirthLimitBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereEngMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereEngReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereGenderLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereHasBirthLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereHasBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereHasDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereHasEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereHasForeignSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereHasReviewFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereHasSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereMainGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereModifiedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereQuantityModifiedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereSelfEnrollmentQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereSelfEnrollmentRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereSpecialDeptType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentSavedData whereSubGroup($value)
 */
class GraduateDepartmentSavedData extends Model
{
    use SoftDeletes;

    protected $table = 'graduate_department_saved_data';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'id', //系所代碼（系統按規則產生）
        'school_code', //學校代碼
        'title', //系所名稱
        'eng_title', //系所英文名稱
        'system', //這是碩士班還是博士班 QQ
        'description', //選系說明
        'eng_description', //選系英文說明
        'memo', //給海聯的備註
        'eng_memo', //給海聯的英文備註
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
        'admission_placement_ratify_quota', //教育部核定聯合分發名額
        'admission_selection_ratify_quota', //教育部核定個人申請名額
        'self_enrollment_ratify_quota', //教育部核定單獨招收(自招)名額
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
}
