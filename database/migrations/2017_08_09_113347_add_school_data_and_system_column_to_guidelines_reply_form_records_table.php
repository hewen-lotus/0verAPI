<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolDataAndSystemColumnToGuidelinesReplyFormRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( DB::table('guidelines_reply_form_records')->count() > 0 ) {
            Schema::table('guidelines_reply_form_records', function (Blueprint $table) {
                $table->string('school_code')->nullable()->comment('學校代碼');
                $table->foreign('school_code', 'school_foreign')->references('id')->on('school_data');
                $table->unsignedInteger('system_id')->nullable()->comment('學制種類（學士, 碩士, 二技, 博士）');
                $table->foreign('system_id', 'system_foreign')->references('id')->on('system_types');
            });

            $all_data = DB::table('guidelines_reply_form_records')->get();

            foreach ($all_data as $data) {
                $checksum = $data->checksum;

                $json_data = json_decode($data->data, true);

                $system_id = $json_data['system_id'];

                $school_history = DB::table('school_history_data')->where('history_id', '=', $json_data['school_history_data'])->first();

                $school_code = $school_history->id;

                DB::table('guidelines_reply_form_records')
                    ->where('checksum', $checksum)
                    ->update(['system_id' => $system_id, 'school_code' => $school_code]);
            }

            DB::statement('ALTER TABLE `guidelines_reply_form_records` CHANGE COLUMN `system_id` `system_id` INT UNSIGNED NOT NULL COMMENT \'學制種類（學士, 碩士, 二技, 博士）\';');
            DB::statement('ALTER TABLE `guidelines_reply_form_records` CHANGE COLUMN `school_code` `school_code` VARCHAR(191) NOT NULL COMMENT \'學校代碼\' COLLATE \'utf8mb4_unicode_ci\';');
        } else {
            Schema::table('guidelines_reply_form_records', function (Blueprint $table) {
                $table->string('school_code')->comment('學校代碼');
                $table->foreign('school_code', 'school_foreign')->references('id')->on('school_data');
                $table->unsignedInteger('system_id')->comment('學制種類（學士, 碩士, 二技, 博士）');
                $table->foreign('system_id', 'system_foreign')->references('id')->on('system_types');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guidelines_reply_form_records', function (Blueprint $table) {
            $table->dropForeign('school_foreign');
            $table->dropForeign('system_foreign');
        });
    }
}
