<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateApplicationDocumentsTableDeptIdForeignInTwoYearTechDeptAndGraduateDept extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('graduate_dept_application_docs', function (Blueprint $table) {
            $table->dropForeign('graduate_dept_application_docs_dept_id_foreign');
            $table->foreign('dept_id')->references('id')->on('graduate_department_data');
        });

        Schema::table('graduate_dept_history_application_docs', function (Blueprint $table) {
            $table->dropForeign('graduate_dept_history_application_docs_dept_id_foreign');
            $table->dropForeign('graduate_dept_history_application_docs_history_id_foreign');
            $table->foreign('dept_id')->references('id')->on('graduate_department_data');
            $table->foreign('history_id')->references('history_id')->on('graduate_department_history_data');
        });

        Schema::table('two_year_tech_dept_application_docs', function (Blueprint $table) {
            $table->dropForeign('two_year_tech_dept_application_docs_dept_id_foreign');
            $table->foreign('dept_id')->references('id')->on('two_year_tech_department_data');
        });

        Schema::table('two_year_tech_dept_history_application_docs', function (Blueprint $table) {
            $table->dropForeign('two_year_tech_dept_history_application_docs_dept_id_foreign');
            $table->dropForeign('two_year_tech_dept_history_application_docs_history_id_foreign');
            $table->foreign('dept_id')->references('id')->on('two_year_tech_department_data');
            $table->foreign('history_id')->references('history_id')->on('two_year_tech_department_history_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graduate_dept_application_docs', function (Blueprint $table) {
            $table->dropForeign('graduate_dept_application_docs_dept_id_foreign');
            $table->foreign('dept_id')->references('id')->on('department_data');
        });

        Schema::table('graduate_dept_history_application_docs', function (Blueprint $table) {
            $table->dropForeign('graduate_dept_history_application_docs_dept_id_foreign');
            $table->dropForeign('graduate_dept_history_application_docs_history_id_foreign');
            $table->foreign('dept_id')->references('id')->on('department_data');
            $table->foreign('history_id')->references('history_id')->on('department_history_data');
        });

        Schema::table('two_year_tech_dept_application_docs', function (Blueprint $table) {
            $table->dropForeign('two_year_tech_dept_application_docs_dept_id_foreign');
            $table->foreign('dept_id')->references('id')->on('department_data');
        });

        Schema::table('two_year_tech_dept_history_application_docs', function (Blueprint $table) {
            $table->dropForeign('two_year_tech_dept_history_application_docs_dept_id_foreign');
            $table->dropForeign('two_year_tech_dept_history_application_docs_history_id_foreign');
            $table->foreign('dept_id')->references('id')->on('department_data');
            $table->foreign('history_id')->references('history_id')->on('department_history_data');
        });
    }
}
