<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\DepartmentGroup
 *
 * @property int $id 學群代碼
 * @property string $title 學群名稱
 * @property string $eng_title 學群英文名稱
 * @property \Carbon\Carbon $created_at
 * @property string $created_by
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentGroup whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentGroup whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentGroup whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DepartmentGroup extends Model
{
    use SoftDeletes;

    protected $table = 'department_groups';

    protected $primaryKey = 'id';

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['deleted_at'];

    protected $casts = [];

    protected $hidden = [];

    protected $fillable = [
        'id', //學群代碼
        'title', //學群名稱
        'eng_title' //學群英文名稱
    ];

}
