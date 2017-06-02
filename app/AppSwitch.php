<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

/**
 * App\AppSwitch
 *
 * @property string $system 系統名稱
 * @property string $function 系統對應的 function name
 * @property \Carbon\Carbon $start_at function 開放時間
 * @property \Carbon\Carbon $end_at function 關閉時間
 * @method static \Illuminate\Database\Query\Builder|\App\AppSwitch whereEndAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AppSwitch whereFunction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AppSwitch whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AppSwitch whereSystem($value)
 * @mixin \Eloquent
 */
class AppSwitch extends Model
{
    protected $table = 'function_open_time';

    public $incrementing = false;

    public $timestamps = false;

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['start_at', 'end_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'system', 'function', 'start_at', 'end_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
}
