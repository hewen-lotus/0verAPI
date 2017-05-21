<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class SystemCommittedData extends Model
{
    use SoftDeletes;

    protected $table = 'system_committed_data';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'saved_id', //對應 saved 表的 id
        'school_code', //學校代碼
        'type', //學制種類（學士, 碩士, 二技, 博士）
        'description', //學制描述
        'eng_description', //'學制描述
        'last_year_admission_amount', //僑生可招收數量（上學年新生總額 10%）（二技參照學士）
        'last_year_surplus_admission_quota', //上學年本地生未招足名額（二技參照學士）
        'ratify_expanded_quota', //本學年教育部核定擴增名額（二技參照學士）
        'ratify_quota_for_self_enrollment', //教育部核定單獨招收名額（只有學士班有）
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
