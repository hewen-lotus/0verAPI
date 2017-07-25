<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\PaperApplicationDocumentAddress
 *
 * @property string $dept_id 系所代碼
 * @property int $type_id 備審資料代碼（系統自動產生）
 * @property string $address
 * @property string $recipient 收件人
 * @property string $phone 收件人電話
 * @property string $email 收件人 email
 * @property string $deadline 收件截止日期
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\PaperApplicationDocumentAddress onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress whereDeptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress whereRecipient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PaperApplicationDocumentAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaperApplicationDocumentAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PaperApplicationDocumentAddress withoutTrashed()
 * @mixin \Eloquent
 */
class PaperApplicationDocumentAddress extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'paper_application_document_address';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = [
        'dept_id',
        'type_id',
        'address',
        'recipient',
        'phone',
        'email',
        'deadline',
    ];

    protected $dates = ['deleted_at'];
}
