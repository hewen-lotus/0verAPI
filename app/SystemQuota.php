<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SystemQuota
 *
 * @property string $school_code 學校代碼
 * @property int $type_id 學制種類（學士, 碩士, 博士）
 * @property int $last_year_admission_amount 上學年度核定日間學制招生名額外加 10% 名額
 * @property int $last_year_surplus_admission_quota 上學年度本地生招生缺額數
 * @property int $expanded_quota 欲申請擴增名額
 * @property int $self_enrollment_quota 單獨招收名額
 * @property int $admission_quota 海外聯合招生管道名額
 * @property string $ip_address 儲存人的IP
 * @property string $updated_by 儲存人
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereAdmissionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereExpandedQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereLastYearAdmissionAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereLastYearSurplusAdmissionQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereSelfEnrollmentQuota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuota whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class SystemQuota extends Model
{
    use SoftDeletes;

    protected $table = 'system_quota';

    //protected $primaryKey = '';

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['deleted_at'];

    protected $casts = [

    ];

    protected $hidden = [

    ];

    protected $fillable = [
        //'school_code', //學校代碼
        //'type_id', //學制種類（學士, 碩士, 二技, 博士）
        //'last_year_admission_amount', //上學年度核定日間學制招生名額外加 10% 名額
        'last_year_surplus_admission_quota', //上學年度本地生招生缺額數
        'expanded_quota', //欲申請擴增名額
        'admission_quota', //海外聯合招生管道名額
        'self_enrollment_quota', //單獨招收名額
        'updated_by', //資料更新者
        'ip_address', //資料更新者的 IP
    ];

    public function updater()
    {
        return $this->belongsTo('App\User', 'created_by', 'username');
    }

}
