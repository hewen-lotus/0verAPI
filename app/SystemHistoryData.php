<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SystemHistoryData
 *
 * @property int $history_id
 * @property string $school_code 學校代碼
 * @property int $type_id 學制種類（學士, 碩士, 二技, 博士）
 * @property string $action
 * @property string $description 學制描述
 * @property string $eng_description 學制描述
 * @property int $last_year_admission_amount 僑生可招收數量（上學年新生總額 10%）（二技參照學士）
 * @property int $last_year_surplus_admission_quota 上學年本地生未招足名額（二技參照學士）
 * @property int $ratify_expanded_quota 本學年教育部核定擴增名額（二技參照學士）
 * @property int $ratify_quota_for_self_enrollment 教育部核定單獨招收名額（只有學士班有）
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DepartmentHistoryData[] $bachelor_departments
 * @property-read \App\SystemData $confirmed
 * @property-read \App\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GraduateDepartmentHistoryData[] $master_departments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GraduateDepartmentHistoryData[] $phd_departments
 * @property-read \App\User $reviewer
 * @property-read \App\SchoolData $school
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TwoYearTechHistoryDepartmentData[] $two_year_tech_departments
 * @property-read \App\SystemType $type
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereInfoStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereLastYearAdmissionAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereLastYearSurplusAdmissionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereQuotaStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereRatifyExpandedQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereRatifyQuotaForSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereReviewAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereReviewBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereReviewMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemHistoryData whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemHistoryData extends Model
{
    use SoftDeletes;

    protected $table = 'system_history_data';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['deleted_at'];

    protected $casts = [

    ];

    protected $hidden = [
        // 'history_id',
        'action',
        'sort_order'
    ];

    protected $fillable = [
        'school_code', //學校代碼
        'action', // 儲存或送出
        'type_id', //學制種類（學士, 碩士, 二技, 博士）
        'description', //學制描述
        'eng_description', //'學制描述
        'last_year_admission_amount', //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
        'last_year_surplus_admission_quota', //上學年本地生未招足名額（二技參照學士）
        'ratify_expanded_quota', //本學年教育部核定擴增名額（二技參照學士）
        // 'ratify_quota_for_self_enrollment', //教育部核定單獨招收名額（只有學士班有）
        'created_by', //按下送出的人是誰
        'ip_address', //按下送出的人的IP
        'info_status', //waiting|confirmed|editing|returned
        'quota_status', //waiting|confirmed|editing|returned
        'review_memo', //讓學校再次修改的原因
        'review_by', //海聯回覆的人員
        'review_at', //海聯回覆的時間點
    ];

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
        return $this->hasOne('App\SystemData', 'history_id', 'history_id');
    }

    public function school()
    {
        return $this->belongsTo('App\SchoolData', 'school_code', 'id');
    }

    public function bachelor_departments()
    {
        return $this->hasMany('App\DepartmentHistoryData', 'school_code', 'school_code');
    }

    public function master_departments()
    {
        return $this->hasMany('App\GraduateDepartmentHistoryData', 'school_code', 'school_code')
            ->where('system_id', '=', 3);
    }

    public function phd_departments()
    {
        return $this->hasMany('App\GraduateDepartmentHistoryData', 'school_code', 'school_code')
            ->where('system_id', '=', 4);
    }

    public function two_year_tech_departments()
    {
        return $this->hasMany('App\TwoYearTechHistoryDepartmentData', 'school_code', 'school_code');
    }

    public function type()
    {
        return $this->belongsTo('App\SystemType', 'type_id', 'id');
    }
}
