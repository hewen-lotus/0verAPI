<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\DepartmentApplicationDocument
 *
 * @property string $dept_id 系所代碼
 * @property int $type_id 備審資料代碼（系統自動產生）
 * @property string $description 詳細說明
 * @property string $eng_description 英文的詳細說明
 * @property bool $required 備審資料是否為必繳
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDeptId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $modifiable 學校是否可修改此備審資料
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereModifiable($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument withoutTrashed()
 * @property-read \App\ApplicationDocumentType $type
 * @property-read \App\DepartmentData $department
 */
class DepartmentApplicationDocument extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $casts = [
        'modifiable' => 'boolean',
        'required' => 'boolean',
    ];

    protected $table = 'dept_application_docs';

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

    public function type()
    {
        return $this->belongsTo('App\ApplicationDocumentType', 'type_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo('App\DepartmentData', 'dept_id', 'id');
    }
}
