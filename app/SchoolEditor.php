<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SchoolEditor
 *
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $chinese_name
 * @property string $english_name
 * @property string $school_code 該使用者所屬學校代碼
 * @property string $organization 該使用者所屬單位名稱
 * @property string $phone 聯絡電話
 * @property bool $admin
 * @property string $last_login 上次登入時間 YYYY-MM-DD HH:MM:SS
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $remember_token
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\SchoolData $school
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereChineseName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereEnglishName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereUsername($value)
 * @mixin \Eloquent
 * @property string $last_move 上次動作時間
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereLastMove($value)
 * @property-read \App\User $user
 * @property bool $has_admin
 * @property string $last_action_at 上次動作時間
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereDeletedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereHasAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereLastActionAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolEditor whereUpdatedBy($value)
 */
class SchoolEditor extends Model
{
    use SoftDeletes;

    protected $table = 'school_editors';

    protected $dateFormat = Carbon::ISO8601;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'school_code', 'organization', 'has_admin', 'last_action_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'username', 'password', 'remember_token', 'school_code'
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'username', 'username');
    }

    public function school()
    {
        return $this->belongsTo('App\SchoolData', 'school_code', 'id');
    }

    public function has_banned()
    {
        if ($this->deleted_at != NULL) {
            return false;
        }

        return true;
    }

    public function last_login_at()
    {
        return $this->user->last_login_at;
    }
}
