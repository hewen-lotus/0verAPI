<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class EvaluationLevel extends Model
{
    use SoftDeletes;

    protected $table = 'evaluation_levels';

    protected $primaryKey = 'id';

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['deleted_at'];

    protected $casts = [];

    protected $hidden = [];

    protected $fillable = [
        'id', //評鑑等級代碼
        'title', //評鑑等級名稱
        'eng_title' //評鑑等級英文名稱
    ];
}
