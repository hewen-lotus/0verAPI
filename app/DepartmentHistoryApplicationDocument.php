<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\DepartmentHistoryApplicationDocument
 *
 * @property string $dept_id 系所代碼
 * @property int $type_id 備審資料代碼（系統自動產生）
 * @property int $history_id 所隸屬的系所歷史資料代碼
 * @property string $description 詳細說明
 * @property string $eng_description 英文的詳細說明
 * @property bool $required 備審資料是否為必繳
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereDeptId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $modifiable 學校是否可修改此備審資料
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereModifiable($value)
 */
class DepartmentHistoryApplicationDocument extends Model
{
    use SoftDeletes;

    protected $table = 'dept_history_application_docs';

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
