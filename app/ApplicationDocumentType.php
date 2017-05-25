<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class ApplicationDocumentType extends Model
{
    use SoftDeletes;

    protected $table = 'application_document_types';

    protected $dateFormat = Carbon::ISO8601;

    protected $fillable = ['name', 'eng_name'];

    protected $dates = ['deleted_at'];
}
