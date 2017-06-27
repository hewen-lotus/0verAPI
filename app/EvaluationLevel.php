<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\EvaluationLevel
 *
 * @property int $id 評鑑等級代碼
 * @property string $title 評鑑等級名稱
 * @property string $eng_title 評鑑等級英文名稱
 * @property \Carbon\Carbon $created_at
 * @property string $created_by
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel whereEngTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\EvaluationLevel withoutTrashed()
 */
class EvaluationLevel extends Model
{
    use SoftDeletes;

    protected $table = 'evaluation_levels';

    protected $primaryKey = 'id';

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['deleted_at'];

    protected $casts = [];

    protected $hidden = [];

    protected $fillable = [
        'id', //評鑑等級代碼
        'title', //評鑑等級名稱
        'eng_title' //評鑑等級英文名稱
    ];
}
