<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class SystemType extends Model
{
    use SoftDeletes;

    protected $table = 'system_types';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = ['title', 'eng_title'];

    protected $dates = ['deleted_at'];

    public function data() {
        return $this->hasMany('App\SystemData', 'type_id', 'id');
    }
}
