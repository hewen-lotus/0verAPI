<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SystemType
 *
 * @property int $id
 * @property string $title 目前可以收學生的學制
 * @property string $eng_title 目前可以收學生的學制的英文
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\SystemType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemType whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemType whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SystemData[] $data
 */
class SystemType extends Model
{
    use SoftDeletes;

    protected $table = 'system_types';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = ['title', 'eng_title'];

    protected $dates = ['deleted_at'];

    public function data() {
        return $this->hasMany('App\SystemData', 'type_id', 'id');
    }
}
