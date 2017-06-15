<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolLastYearSelfEnrollmentAndFiveYearStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_last_year_self_enrollment_and_five_year_status', function (Blueprint $table) {
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code', 'school_code_foreign')->references('id')->on('school_data');
            $table->string('has_five_year_student_allowed')->comment('去年中五招生狀態');
            $table->string('has_self_enrollment')->comment('去年自招招生狀態');
            $table->primary('school_code', 'pkey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_last_year_self_enrollment_and_five_year_status', function (Blueprint $table) {
            $table->dropForeign('school_code_foreign');
        });

        Schema::dropIfExists('school_last_year_self_enrollment_and_five_year_status');
    }
}
