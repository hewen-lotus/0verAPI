<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\GraduateDepartmentHistoryApplicationDocument
 *
 * @mixin \Eloquent
 */
class GraduateDepartmentHistoryApplicationDocument extends Model
{
    use SoftDeletes;

    protected $table = 'graduate_dept_history_application_docs';

    public $incrementing = false;

    protected $dateFormat = Carbon::ISO8601;

    protected $casts = [
        'modifiable' => 'boolean',
        'required' => 'boolean',
    ];

    protected $fillable = [
        'history_id',
        'dept_id',
        'type_id',
        'description',
        'eng_description',
        'modifiable',
        'required',
    ];

    protected $dates = ['deleted_at'];
}
