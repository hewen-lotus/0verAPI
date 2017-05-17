<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $chinese_name
 * @property string $english_name
 * @property string $phone 聯絡電話
 * @property string $last_login 上次登入時間 YYYY-MM-DD HH:MM:SS
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $remember_token
 * @method static \Illuminate\Database\Query\Builder|\App\User whereChineseName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEnglishName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 * @property-read \App\Admin $admin
 * @property-read \App\SchoolEditor $school_editor
 * @property-read \App\SchoolReviewer $school_reviewer
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'username';

    public $incrementing = false;

    protected $dateFormat = Carbon::ISO8601;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'name', 'eng_name', 'phone', 'last_login_at'
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
