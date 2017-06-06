<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemQuotaRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 紀錄每學年每校每學制
        Schema::create('system_quota_records', function (Blueprint $table) {
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->unsignedInteger('type_id')->comment('學制種類（學士, 碩士, 博士）');
            $table->foreign('type_id')->references('id')->on('system_types');
            $table->string('academic_year')->comment('西元學年');
            $table->unsignedInteger('admission_selection_amount')->comment('個人申請錄取人數');
            $table->unsignedInteger('admission_placement_amount')->comment('聯合分發錄取人數');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['school_code', 'type_id', 'academic_year']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_quota_records', function (Blueprint $table) {
            $table->dropForeign('system_quota_records_school_code_foreign');
            $table->dropForeign('system_quota_records_type_id_foreign');
        });

        Schema::dropIfExists('system_quota_records');
    }
}
