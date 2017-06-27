<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\GraduateDepartmentApplicationDocument
 *
 * @mixin \Eloquent
 */
class GraduateDepartmentApplicationDocument extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $casts = [
        'modifiable' => 'boolean',
        'required' => 'boolean',
    ];

    protected $table = 'graduate_dept_application_docs';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'dept_id',
        'type_id',
        'description',
        'eng_description',
        'modifiable',
        'required'
    ];

    protected $dates = ['deleted_at'];
}
