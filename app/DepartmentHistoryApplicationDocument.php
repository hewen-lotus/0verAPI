<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\DepartmentHistoryApplicationDocument
 *
 * @property string $dept_id 系所代碼
 * @property int $type_id 備審資料代碼（系統自動產生）
 * @property int $history_id 所隸屬的系所歷史資料代碼
 * @property string $description 詳細說明
 * @property string $eng_description 英文的詳細說明
 * @property bool $required 備審資料是否為必繳
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereDeptId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereEngDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $modifiable 學校是否可修改此備審資料
 * @method static \Illuminate\Database\Query\Builder|\App\DepartmentHistoryApplicationDocument whereModifiable($value)
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
