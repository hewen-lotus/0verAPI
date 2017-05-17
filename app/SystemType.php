<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SystemTypes
 *
 * @property string $type 目前可以收學生的學制
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\SystemTypes whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemTypes whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemTypes whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemTypes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemTypes extends Model
{
    use SoftDeletes;

    protected $table = 'system_types';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = ['type', 'eng_type'];

    protected $dates = ['deleted_at'];
}
