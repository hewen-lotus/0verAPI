<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\GraduateDepartmentCommittedData
 *
 * @mixin \Eloquent
 */
class GraduateDepartmentCommittedData extends Model
{
    use SoftDeletes;

    protected $table = 'graduate_department_committed_data';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'id', //系所代碼（系統按規則產生）
        'saved_id',
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
        'committed_by', //送出資料的人是誰
        'quantity_committed_by', //送出名額的人是誰
        'ip_address', //按下送出的人的IP
        'quantity_review_status', //waiting|confirmed(by 教育部)|editing
        'review_status', //'waiting|confirmed(by 海聯)|editing
        'review_memo', //讓學校再次修改的原因
        'replied_by', //海聯回覆的人員
        'replied_at', //海聯回覆的時間點
        'confirmed_by', //海聯審查的人員
        'confirmed_at', //海聯審查的時間點
    ];

    protected $dates = ['deleted_at'];
}
