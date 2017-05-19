<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\Admin
 *
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $chinese_name
 * @property bool $admin
 * @property string $last_login 上次登入時間 YYYY-MM-DD HH:MM:SS
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $remember_token
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereChineseName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUsername($value)
 * @mixin \Eloquent
 * @property string $last_move 上次動作時間
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereLastMove($value)
 * @property-read \App\User $user
 * @property bool $has_admin
 * @property string $last_action_at 上次動作時間
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereDeletedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereHasAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereLastActionAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUpdatedBy($value)
 */
class Admin extends Model
{
    use SoftDeletes;

    protected $table = 'admins';

    protected $dateFormat = Carbon::ISO8601;

    protected $casts = [
        'has_admin' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'has_admin', 'last_action_at'
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

    public function user()
    {
        return $this->belongsTo('App\User', 'username', 'username');
    }
}