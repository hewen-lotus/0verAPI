<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * App\ApplicationDocumentType
 *
 * @property int $id
 * @property string $name
 * @property string $eng_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationDocumentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationDocumentType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationDocumentType whereEngName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationDocumentType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationDocumentType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationDocumentType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $system_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationDocumentType onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApplicationDocumentType whereSystemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationDocumentType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationDocumentType withoutTrashed()
 */
class ApplicationDocumentType extends Model
{
    use SoftDeletes;

    protected $table = 'application_document_types';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = ['name', 'eng_name', 'system_id'];

    protected $dates = ['deleted_at'];
}
