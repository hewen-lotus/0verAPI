<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\SystemQuotaRecord
 *
 * @property string $school_code 學校代碼
 * @property int $type_id 學制種類（學士, 碩士, 博士）
 * @property string $academic_year 西元學年
 * @property int $admission_selection_amount 個人申請錄取人數
 * @property int $admission_placement_amount 聯合分發錄取人數
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord whereAcademicYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord whereAdmissionPlacementAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord whereAdmissionSelectionAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord whereSchoolCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SystemQuotaRecord withoutTrashed()
 */
class SystemQuotaRecord extends Model
{
    use SoftDeletes;

    protected $table = 'system_quota_records';

    public $incrementing = false;

    protected $dateFormat = Carbon::ISO8601;

    protected $dates = ['deleted_at'];

    protected $fillable = [

    ];
}
