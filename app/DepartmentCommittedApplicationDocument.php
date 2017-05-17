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
 */
class DepartmentCommittedApplicationDocument extends Model
{
    use SoftDeletes;

    protected $table = 'department_committed_application_documents';

    protected $primaryKey = 'history_id';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'saved_id'
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
