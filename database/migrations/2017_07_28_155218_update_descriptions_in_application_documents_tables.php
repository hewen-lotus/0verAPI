<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDescriptionsInApplicationDocumentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dept_application_docs', function (Blueprint $table) {
            $table->longText('description')->change();
            $table->longText('eng_description')->change();
        });

        Schema::table('dept_history_application_docs', function (Blueprint $table) {
            $table->longText('description')->change();
            $table->longText('eng_description')->change();
        });

        Schema::table('graduate_dept_application_docs', function (Blueprint $table) {
            $table->longText('description')->change();
            $table->longText('eng_description')->change();
        });

        Schema::table('graduate_dept_history_application_docs', function (Blueprint $table) {
            $table->longText('description')->change();
            $table->longText('eng_description')->change();
        });

        Schema::table('two_year_tech_dept_application_docs', function (Blueprint $table) {
            $table->longText('description')->change();
            $table->longText('eng_description')->change();
        });

        Schema::table('two_year_tech_dept_history_application_docs', function (Blueprint $table) {
            $table->longText('description')->change();
            $table->longText('eng_description')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
