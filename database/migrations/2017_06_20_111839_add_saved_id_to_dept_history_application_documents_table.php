<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSavedIdToDeptHistoryApplicationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dept_history_application_docs', function (Blueprint $table) {
            $table->unsignedInteger('saved_id');
            $table->foreign('saved_id')->references('history_id')->on('department_history_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dept_history_application_docs', function (Blueprint $table) {
            $table->dropForeign('dept_history_application_docs_saved_id_foreign');
        });
    }
}
