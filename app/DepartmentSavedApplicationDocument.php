<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\DepartmentApplicationDocument
 *
 * @property string $dept_id
 * @property int $document_type_id
 * @property string $detail
 * @property string $eng_detail
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDeptId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDocumentTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereEngDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $history_id
 * @property string $description 詳細說明
 * @property string $eng_description 英文的詳細說明
 * @property bool $required 備審資料是否為必繳
 * @property string $modified_by 按下儲存的人是誰
 * @property string $ip_address 按下儲存的人的IP
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedApplicationDocument whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedApplicationDocument whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedApplicationDocument whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedApplicationDocument whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedApplicationDocument whereModifiedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentSavedApplicationDocument whereRequired($value)
 */
class DepartmentSavedApplicationDocument extends Model
{
    use SoftDeletes;

    protected $table = 'department_saved_application_documents';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'dept_id',
        'document_type_id',
        'detail',
        'eng_detail',
        'modified_by', //儲存資料的人是誰
        'quantity_modified_by', //儲存名額的人是誰
        'ip_address', //按下儲存的人的IP
    ];

    protected $dates = ['deleted_at'];
}
