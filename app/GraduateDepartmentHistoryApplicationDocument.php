<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\GraduateDepartmentHistoryApplicationDocument
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
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryApplicationDocument onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereEngDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereModifiable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GraduateDepartmentHistoryApplicationDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryApplicationDocument withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentHistoryApplicationDocument withoutTrashed()
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
