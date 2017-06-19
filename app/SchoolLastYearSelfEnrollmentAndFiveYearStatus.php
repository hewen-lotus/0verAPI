<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SchoolLastYearSelfEnrollmentAndFiveYearStatus
 *
 * @property string $school_code 學校代碼
 * @property bool $has_five_year_student_allowed 去年中五招生狀態
 * @property bool $has_self_enrollment 去年自招招生狀態
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolLastYearSelfEnrollmentAndFiveYearStatus whereHasFiveYearStudentAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolLastYearSelfEnrollmentAndFiveYearStatus whereHasSelfEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SchoolLastYearSelfEnrollmentAndFiveYearStatus whereSchoolCode($value)
 * @mixin \Eloquent
 */
class SchoolLastYearSelfEnrollmentAndFiveYearStatus extends Model
{
    protected $table = 'school_last_year_self_enrollment_and_five_year_status';

    protected $primaryKey = 'school_code';

    public $timestamps = false;

    public $incrementing = false;

    protected $casts = [
        'has_five_year_student_allowed' => 'boolean',
        'has_self_enrollment' => 'boolean'
    ];

    protected $fillable = [
        //
    ];

    protected $hidden = [
        //
    ];
}
