<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

/**
 * App\AdmissionPlacementStepQuota
 *
 * @property string $dept_id 系所代碼
 * @property int $s1 第一梯次(s1)：馬來西亞(持華文獨中統考文憑)
 * @property int $s2 第二梯次(s2)：馬來西亞(STPM/A-LEVEL/O-LEVEL/SPM)、一般地區(歐洲、美洲、非洲、大洋洲及其他免試地區)
 * @property int $s3 第三梯次(s3)：海外測驗(日本、韓國、菲律賓、新加坡、泰北、緬甸、海外臺灣學校高中畢業生及澳門)
 * @property int $s4 第四梯次(s4)：國立臺灣師範大學僑生先修部結業生
 * @property int $s5 第五梯次(s5)：印尼輔訓班結業生、香港
 * @property-read \App\DepartmentData $department
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdmissionPlacementStepQuota whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdmissionPlacementStepQuota whereS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdmissionPlacementStepQuota whereS2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdmissionPlacementStepQuota whereS3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdmissionPlacementStepQuota whereS4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdmissionPlacementStepQuota whereS5($value)
 * @mixin \Eloquent
 */
class AdmissionPlacementStepQuota extends Model
{
    protected $table = 'admission_placement_step_quota';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = 'dept_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = ['dept_id', 's1', 's2', 's3', 's4', 's5'];

    public function department()
    {
        return $this->belongsTo('App\DepartmentData', 'dept_id', 'id');
    }
}
