<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'username';

    public $incrementing = false;

    protected $dateFormat = Carbon::ISO8601;

    protected $appends = ['has_banned'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'name', 'eng_name', 'phone', 'last_login_at', 'created_by', 'updated_by', 'deleted_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public function getHasBannedAttribute()
    {
        return $this->deleted_at != NULL;
    }

    public function admin()
    {
        return $this->hasOne('App\Admin', 'username', 'username');
    }

    public function school_editor()
    {
        return $this->hasOne('App\SchoolEditor', 'username', 'username');
    }

    public function school_reviewer()
    {
        return $this->hasOne('App\SchoolReviewer', 'username', 'username');
    }
}
