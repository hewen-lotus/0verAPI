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
class SystemCommittedData extends Model
{
    use SoftDeletes;

    protected $table = 'system_data';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'school_code', //學校代碼
        'system', //學制種類（學士, 碩士, 二技, 博士）
        'description', //學制描述
        'eng_description', //'學制描述
        'quantity_of_overseas', //僑生可招收數量
        'surplus', //上學年本地生未招足名額（二技參照學士）
        'expanded', //本學年教育部核定擴增名額（二技參照學士）
        'distribution', //聯合分發名額（聯招；研究所沒有）
        'personal_apply', //個人申請名額（聯招）
        'recruit_by_school', //自招名額
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

}
