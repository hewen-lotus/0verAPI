<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SystemData
 *
 * @property string $school_code 學校代碼
 * @property int $type_id 學制種類（學士, 碩士, 二技, 博士）
 * @property string $description 學制描述
 * @property string $eng_description 學制描述
 * @property int $last_year_admission_amount 僑生可招收數量（上學年新生總額 10%）（二技參照學士）
 * @property int $last_year_surplus_admission_quota 上學年本地生未招足名額（二技參照學士）
 * @property int $ratify_expanded_quota 本學年教育部核定擴增名額（二技參照學士）
 * @property int $ratify_quota_for_self_enrollment 教育部核定單獨招收名額（只有學士班有）
 * @property string $confirmed_by 資料由哪位海聯人員確認匯入的
 * @property string $confirmed_at 資料確認匯入的時間
 * @property int $history_id 從哪一筆歷史紀錄匯入的
 * @property \Carbon\Carbon $created_at
 * @property string $updated_by 資料最後更新者
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereConfirmedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereConfirmedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereLastYearAdmissionAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereLastYearSurplusAdmissionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereRatifyExpandedQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereRatifyQuotaForSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemData whereUpdatedBy($value)
 * @mixin \Eloquent
 * @property-read \App\SchoolData $school
 * @property-read \App\SystemType $type
 */
class SystemData extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'system_data';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'school_code', //學校代碼
        'type_id', //學制種類（學士, 碩士, 二技, 博士）
        'description', //學制描述
        'eng_description', //'學制描述
        'last_year_admission_amount', //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
        'last_year_surplus_admission_quota', //上學年本地生未招足名額（二技參照學士）
        'ratify_expanded_quota', //本學年教育部核定擴增名額（二技參照學士）
        'ratify_quota_for_self_enrollment', //教育部核定單獨招收名額（只有學士班有）
        'confirmed_by',
        'confirmed_at',
        'history_id',
        'updated_by'
    ];

    protected $dates = ['deleted_at'];

    public function type() {
        return $this->belongsTo('App\SystemType', 'type_id', 'id');
    }

    public function school() {
        return $this->belongsTo('App\SchoolData', 'school_code', 'id');
    }
}
