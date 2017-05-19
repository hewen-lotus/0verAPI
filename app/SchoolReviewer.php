<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SchoolReviewer
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
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereChineseName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereEnglishName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereUsername($value)
 * @mixin \Eloquent
 * @property string $last_move 上次動作時間
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereLastMove($value)
 * @property-read \App\User $user
 * @property bool $has_admin
 * @property string $last_action_at 上次動作時間
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereDeletedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereHasAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereLastActionAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolReviewer whereUpdatedBy($value)
 */
class SchoolReviewer extends Model
{
    use SoftDeletes;

    protected $table = 'school_reviewers';

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
}