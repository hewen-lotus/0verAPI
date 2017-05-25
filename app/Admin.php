<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Admin extends Model
{
    use SoftDeletes;

    protected $table = 'admins';

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
        'username', 'has_admin', 'last_action_at', 'created_by', 'updated_by', 'deleted_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'username', 'password', 'remember_token'
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
}