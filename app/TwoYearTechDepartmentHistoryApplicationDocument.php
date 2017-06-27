<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\TwoYearTechDepartmentHistoryApplicationDocument
 *
 * @mixin \Eloquent
 * @property string $dept_id 系所代碼
 * @property int $type_id 備審資料代碼（系統自動產生）
 * @property int $history_id 所隸屬的系所歷史資料代碼
 * @property string $description 詳細說明
 * @property string $eng_description 英文的詳細說明
 * @property bool $modifiable 學校是否可修改此備審資料
 * @property bool $required 備審資料是否為必繳
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereEngDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereModifiable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentHistoryApplicationDocument withoutTrashed()
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
