<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class DepartmentApplicationDocument extends Model
{
    use SoftDeletes;

    protected $table = 'dept_application_docs';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = ['dept_id', 'type_id', 'description', 'eng_description', 'required'];

    protected $dates = ['deleted_at'];
}
