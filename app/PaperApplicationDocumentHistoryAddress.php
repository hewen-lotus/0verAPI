<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\PaperApplicationDocumentHistoryAddress
 *
 * @property int $id
 * @property string $dept_id 系所代碼
 * @property int $type_id 備審資料代碼（系統自動產生）
 * @property string $address
 * @property string $recipient 收件人
 * @property string $phone 收件人電話
 * @property string $email 收件人 email
 * @property string $deadline 收件截止日期
 * @property string|null $created_by 此歷史紀錄建立者
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\PaperApplicationDocumentHistoryAddress onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereRecipient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentHistoryAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaperApplicationDocumentHistoryAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PaperApplicationDocumentHistoryAddress withoutTrashed()
 * @mixin \Eloquent
 */
class PaperApplicationDocumentHistoryAddress extends Model
{
    use SoftDeletes;

    protected $table = 'paper_application_document_history_address';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'dept_id',
        'type_id',
        'address',
        'recipient',
        'phone',
        'email',
        'deadline',
        'created_by'
    ];

    protected $dates = ['deleted_at'];
}
