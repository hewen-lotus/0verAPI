<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\TwoYearTechDepartmentHistoryApplicationDocument
 *
 * @mixin \Eloquent
 */
class TwoYearTechDepartmentHistoryApplicationDocument extends Model
{
    use SoftDeletes;

    protected $table = 'two_year_tech_dept_history_application_docs';

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
