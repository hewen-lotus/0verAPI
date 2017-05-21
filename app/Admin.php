<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\Admin
 *
 * @property string $username
 * @property bool $has_admin
 * @property string $last_action_at 上次動作時間
 * @property \Carbon\Carbon $created_at
 * @property string $created_by
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 * @property \Carbon\Carbon $deleted_at
 * @property string $deleted_by
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereDeletedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereHasAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereLastActionAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUsername($value)
 * @mixin \Eloquent
 * @property-read mixed $has_banned
 */
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