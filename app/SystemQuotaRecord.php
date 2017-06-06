<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class SystemQuotaRecord extends Model
{
    use SoftDeletes;

    protected $table = 'system_quota_records';

    public $incrementing = false;

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        
    ];
}
