<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SystemData
 *
 * @property string $school_code 學校代碼
 * @property string $system 學制種類（學士, 碩士, 二技, 博士）
 * @property int $quantity_of_overseas 僑生可招收數量
 * @property int $surplus 上學年本地生未招足名額（二技參照學士）
 * @property int $expanded 本學年教育部核定擴增名額（二技參照學士）
 * @property int $distribution 聯合分發名額（聯招；研究所沒有）
 * @property int $personal_apply 個人申請名額（聯招）
 * @property int $recruit_by_school 自招名額
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereDistribution($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereExpanded($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData wherePersonalApply($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereQuantityOfOverseas($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereRecruitBySchool($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereSurplus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereSystem($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $description 學制描述
 * @property string $eng_description 學制描述
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereEngDescription($value)
 */
class SystemSavedData extends Model
{
    use SoftDeletes;

    protected $table = 'system_saved_data';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'school_code', //學校代碼
        'type', //學制種類（學士, 碩士, 二技, 博士）
        'description', //學制描述
        'eng_description', //'學制描述
        'last_year_admission_amount', //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
        'last_year_surplus_admission_quota', //上學年本地生未招足名額（二技參照學士）
        'ratify_expanded_quota', //本學年教育部核定擴增名額（二技參照學士）
        'ratify_quota_for_self_enrollment', //教育部核定單獨招收名額（只有學士班有）
        'modified_by', //儲存資料的人是誰
        'quantity_modified_by', //儲存名額的人是誰
        'ip_address', //按下儲存的人的IP
    ];

    protected $dates = ['deleted_at'];
}
