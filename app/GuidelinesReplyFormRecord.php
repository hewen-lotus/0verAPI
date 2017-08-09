<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

/**
 * App\GuidelinesReplyFormRecord
 *
 * @property string $checksum pdf 檢查碼
 * @property string $data pdf 內含資料
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuidelinesReplyFormRecord whereChecksum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuidelinesReplyFormRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuidelinesReplyFormRecord whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuidelinesReplyFormRecord whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuidelinesReplyFormRecord whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $school_code 學校代碼
 * @property int $system_id 學制種類（學士, 碩士, 二技, 博士）
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuidelinesReplyFormRecord whereSchoolCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GuidelinesReplyFormRecord whereSystemId($value)
 */
class GuidelinesReplyFormRecord extends Model
{
    public $timestamps = false;

    protected $table = 'guidelines_reply_form_records';

    protected $primaryKey = 'checksum';

    public $incrementing = false;

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'checksum', 'data', 'school_code', 'system_id', 'created_at'
    ];
}
