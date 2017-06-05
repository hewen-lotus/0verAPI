<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

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
        'school_code', //學校代碼
        'type_id', //學制種類（學士, 碩士, 二技, 博士）
        'last_year_admission_amount', //上學年度核定日間學制招生名額外加 10% 名額
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
