<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupGraduateDepartmentDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('graduate_department_data', function (Blueprint $table) {
            $table->foreign('school_code')->references('id')->on('school_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graduate_department_data', function (Blueprint $table) {
            $table->dropForeign('graduate_department_data_school_code_foreign');
        });
    }
}
