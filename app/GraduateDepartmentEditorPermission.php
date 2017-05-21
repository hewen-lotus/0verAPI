<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\GraduateDepartmentEditorPermission
 *
 * @property string $username
 * @property string $dept_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\GraduateDepartmentData $department
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentEditorPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentEditorPermission whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentEditorPermission whereDeptId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentEditorPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GraduateDepartmentEditorPermission whereUsername($value)
 * @mixin \Eloquent
 */
class GraduateDepartmentEditorPermission extends Model
{
    use SoftDeletes;

    protected $table = 'graduate_department_editor_permissions';

    protected $primaryKey = 'username';

    public $incrementing = false;

    protected $dateFormat = Carbon::ISO8601;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'dept_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'username', 'username');
    }

    public function department()
    {
        return $this->belongsTo('App\GraduateDepartmentData', 'dept_id', 'id');
    }
}
