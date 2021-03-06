<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SchoolEditor
 *
 * @property string $username
 * @property string $organization 該使用者所屬單位名稱
 * @property bool $has_admin
 * @property string $last_action_at 上次動作時間
 * @property \Carbon\Carbon $created_at
 * @property string $created_by
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 * @property \Carbon\Carbon $deleted_at
 * @property string $deleted_by
 * @property string $school_code 該使用者所屬學校代碼
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DepartmentEditorPermission[] $department_permissions
 * @property-read mixed $has_banned
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GraduateDepartmentEditorPermission[] $graduate_department_permissions
 * @property-read \App\SchoolData $school
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TwoYearTechDepartmentEditorPermission[] $two_year_tech_department_permissions
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereDeletedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereHasAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereLastActionAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereUsername($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor withoutTrashed()
 */
class SchoolEditor extends Model
{
    use SoftDeletes;

    protected $table = 'school_editors';

    protected $primaryKey = 'username';

    public $incrementing = false;

    protected $dateFormat = Carbon::ISO8601;

    protected $appends = ['has_banned'];

    protected $casts = [
        'has_admin' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'school_code', 'organization', 'has_admin', 'last_action_at', 'created_by', 'updated_by', 'deleted_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'// 'school_code', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function getHasBannedAttribute()
    {
        return $this->deleted_at != NULL;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'username', 'username');
    }

    public function school()
    {
        return $this->belongsTo('App\SchoolData', 'school_code', 'id');
    }

    public function department_permissions()
    {
        return $this->hasMany('App\DepartmentEditorPermission', 'username', 'username');
    }

    public function graduate_department_permissions()
    {
        return $this->hasMany('App\GraduateDepartmentEditorPermission', 'username', 'username');
    }

    public function two_year_tech_department_permissions()
    {
        return $this->hasMany('App\TwoYearTechDepartmentEditorPermission', 'username', 'username');
    }
}
