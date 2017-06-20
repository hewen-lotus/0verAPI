<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSavedIdToTwoYearTechDeptHistoryApplicationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('two_year_tech_dept_history_application_docs', function (Blueprint $table) {
            $table->unsignedInteger('saved_id');
            $table->foreign('saved_id')->references('history_id')->on('two_year_tech_department_history_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('two_year_tech_dept_history_application_docs', function (Blueprint $table) {
            $table->dropForeign('two_year_tech_dept_history_application_docs_saved_id_foreign');
        });
    }
}
