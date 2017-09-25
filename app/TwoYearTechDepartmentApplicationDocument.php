<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\TwoYearTechDepartmentApplicationDocument
 *
 * @mixin \Eloquent
 * @property string $dept_id 系所代碼
 * @property int $type_id 備審資料代碼（系統自動產生）
 * @property string $description 詳細說明
 * @property string $eng_description 英文的詳細說明
 * @property bool $modifiable 學校是否可修改此備審資料
 * @property bool $required 備審資料是否為必繳
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentApplicationDocument onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentApplicationDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentApplicationDocument whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentApplicationDocument whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentApplicationDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentApplicationDocument whereEngDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentApplicationDocument whereModifiable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentApplicationDocument whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentApplicationDocument whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoYearTechDepartmentApplicationDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentApplicationDocument withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\TwoYearTechDepartmentApplicationDocument withoutTrashed()
 * @property-read \App\ApplicationDocumentType $type
 */
class TwoYearTechDepartmentApplicationDocument extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $casts = [
        'modifiable' => 'boolean',
        'required' => 'boolean',
    ];

    protected $table = 'two_year_tech_dept_application_docs';

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

    public function paper()
    {
        return $this->hasOne('App\PaperApplicationDocumentAddress', 'type_id', 'type_id');
    }
}
