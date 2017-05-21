<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class SystemTypes extends Model
{
    use SoftDeletes;

    protected $table = 'system_types';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = ['type', 'eng_type'];

    protected $dates = ['deleted_at'];
}
