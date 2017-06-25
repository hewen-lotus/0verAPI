<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class DepartmentGroup extends Model
{
    use SoftDeletes;

    protected $table = 'department_groups';

    protected $primaryKey = 'id';

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['deleted_at'];

    protected $casts = [];

    protected $hidden = [];

    protected $fillable = [
        'id', //學群代碼
        'title', //學群名稱
        'eng_title' //學群英文名稱
    ];

}
