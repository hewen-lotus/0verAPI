<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\TwoYearTechDepartmentData
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
 * @property bool $day_school 系所是否有二技日間部學制
 * @property bool $special_class 是否招收僑生專班
 * @property bool $special_class_foriegn 是否招收外生專班
 * @property bool $approve_no_of_special_class 僑生專班報部文號
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
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereAfterBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereApproveNoOfSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereBeforeBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereChoiceMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereDaySchool($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereDecreaseReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereDeptGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereDeptMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereDocMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEngChoiceMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEngDeptMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEngDocMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEngUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEvaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereLastYearPersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereLastYearPersonalApplyOffer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData wherePersonalApplyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereRatify($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSelfRecurit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSelfRecuritAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSexLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSpecialClassForiegn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSpecialDept($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSubDeptGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereUrl($value)
 * @mixin \Eloquent
 * @property string $approval_document_of_special_class 僑生專班報部公文電子檔
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereApprovalDocumentOfSpecialClass($value)
 * @property string $description 選系說明
 * @property string $eng_description 選系英文說明
 * @property string $memo 給海聯的備註
 * @property string $eng_memo 給海聯的英文備註
 * @property int $admission_selection_quota 個人申請名額
 * @property bool $has_self_enrollment 是否有自招
 * @property int $self_enrollment_quota 自招名額
 * @property bool $has_special_class 是否招收僑生專班
 * @property string $approval_doc_of_special_class 招收僑生專班核定公文電子檔(file path)
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
 * @property bool $has_review_fee 是否要收審查費用
 * @property string $review_fee_detail 審查費用細節
 * @property string $eng_review_fee_detail 審查費用英文細節
 * @property-read \App\SchoolData $school
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereAdmissionPlacementRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereAdmissionSelectionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereAdmissionSelectionRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereApprovalDocOfSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereBirthLimitAfter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereBirthLimitBefore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEngMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereEngReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereGenderLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereHasBirthLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereHasBuHweiHwaWen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereHasDisabilities($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereHasEngTaught($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereHasForeignSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereHasReviewFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereHasSpecialClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereMainGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereReviewFeeDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSelfEnrollmentQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSelfEnrollmentRatifyQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSpecialDeptType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentData whereSubGroup($value)
 */
class TwoYearTechDepartmentData extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'two_year_tech_department_data';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'id', //系所代碼（系統按規則產生）
        'school_code', //學校代碼
        'title', //系所名稱
        'eng_title', //系所英文名稱
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
        'approve_no_of_special_class', //招收僑生專班核定文號
        'approval_doc_of_special_class', //招收僑生專班核定公文電子檔(file path)
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
    ];

    protected $dates = ['deleted_at'];

    public function school()
    {
        return $this->belongsTo('App\SchoolData', 'school_code', 'id');
    }
}
