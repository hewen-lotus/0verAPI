<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\DepartmentApplicationDocument
 *
 * @property string $dept_id
 * @property int $document_type_id
 * @property string $detail
 * @property string $eng_detail
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDeptId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereDocumentTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereEngDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentApplicationDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $history_id
 * @property int $saved_id 對應 saved 表的 id
 * @property string $description 詳細說明
 * @property string $eng_description 英文的詳細說明
 * @property bool $required 備審資料是否為必繳
 * @property string $committed_by 按下送出的人是誰
 * @property string $ip_address 按下送出的人的IP
 * @property string $review_status 資料 review 狀態（waiting|confirmed|editing）
 * @property string $review_memo 讓學校再次修改的原因
 * @property string $replied_by 海聯回覆的人員
 * @property string $replied_at 海聯回覆的時間點
 * @property string $confirmed_by 海聯審查的人員
 * @property string $confirmed_at 海聯審查的時間點
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereCommittedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereConfirmedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereConfirmedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereRepliedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereRepliedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereReviewMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereReviewStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentCommittedApplicationDocument whereSavedId($value)
 */
class DepartmentHistoryApplicationDocument extends Model
{
    use SoftDeletes;

    protected $table = 'dept_history_application_docs';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'saved_id',
        'dept_id',
        'document_type_id',
        'detail',
        'eng_detail',
        'committed_by', //送出資料的人是誰
        'quantity_committed_by', //送出名額的人是誰
        'ip_address', //按下送出的人的IP
        'quantity_status', //waiting|confirmed(by 教育部)|editing
        'review_status', //waiting|confirmed(by 海聯)|editing
        'reason', //讓學校再次修改的原因
        'replied_by', //海聯回覆的人員
        'replied_at', //海聯回覆的時間點
        'confirmed_by', //海聯審查的人員
        'confirmed_at', //海聯審查的時間點
    ];

    protected $dates = ['deleted_at'];
}
