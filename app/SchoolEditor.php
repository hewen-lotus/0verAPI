<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

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
