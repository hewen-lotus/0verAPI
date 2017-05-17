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
 */
class DepartmentCommittedData extends Model
{
    use SoftDeletes;

    protected $table = 'department_committed_data';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'id', //系所代碼（系統按規則產生）
        'saved_id', //對應 saved 表的 id
        'school_code', //學校代碼
        'card_code', //讀卡代碼
        'title', //系所名稱
        'eng_title', //系所英文名稱
        'choice_memo', //選系說明
        'eng_choice_memo', //選系英文說明
        'doc_memo', //書審說明
        'eng_doc_memo', //書審英文說明
        'dept_memo', //備註
        'eng_dept_memo', //英文備註
        'url', //系網站網址
        'eng_url', //英文系網站網址
        'last_year_offer', //去年聯合分發錄取名額
        'decrease_reason', //減招原因
        'last_year_amount', //去年聯合分發名額（只有學士班有聯合分發）
        'amount', //聯合分發名額（只有學士班有聯合分發）
        'personal_apply_amount', //個人申請名額
        'last_year_personal_apply_amount', //去年個人申請名額
        'last_year_personal_apply_offer', //去年個人申請錄取名額
        'self_recurit', //是否有自招
        'self_recurit_amount', //自招名額
        'special_class', //是否招收僑生專班
        'special_class_foriegn', //是否招收外生專班
        'special_dept', //特殊系所（醫、牙、中醫、藝術）
        'sex_limit', //性別限制
        'ratify', //核定名額
        'rank', //志願排名
        'sortorder', //輸出排序
        'after_birth', //限…之後出生
        'before_birth', //限…之前出生
        'dept_group', //18大學群代碼
        'sub_dept_group', //次要18大學群代碼
        'eng_taught', //全英文授課
        'disabilities', //是否招收身障學生
        'BuHweiHwaWen', //是否招收不具華文基礎學生
        'evaluation', //系所評鑑等級
        'committed_by', //送出資料的人是誰
        'quantity_committed_by', //送出名額的人是誰
        'ip_address', //按下送出的人的IP
        'quantity_status', //waiting|confirmed(by 教育部)|editing
        'review_status', //'waiting|confirmed(by 海聯)|editing
        'reason', //讓學校再次修改的原因
        'replied_by', //海聯回覆的人員
        'replied_at', //海聯回覆的時間點
        'confirmed_by', //海聯審查的人員
        'confirmed_at', //海聯審查的時間點
    ];

    protected $dates = ['deleted_at'];

    public function school()
    {
        return $this->belongsTo('App\SchoolData', 'school_code', 'id');
    }
}
