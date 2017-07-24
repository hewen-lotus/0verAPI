<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuidelinesReplyFormRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guidelines_reply_form_records', function (Blueprint $table) {
            $table->string('checksum')->primary()->comment('pdf 檢查碼');
            $table->longText('data')->comment('pdf 內含資料');
            $table->string('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guidelines_reply_form_records');
    }
}
