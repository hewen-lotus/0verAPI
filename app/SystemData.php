<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class SystemData extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'system_data';

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
    ];

    protected $dates = ['deleted_at'];
}
