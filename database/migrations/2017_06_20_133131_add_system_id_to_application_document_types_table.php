<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSystemIdToApplicationDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_document_types', function (Blueprint $table) {
            $table->unsignedInteger('system_id')->nullable();
            $table->foreign('system_id')->references('id')->on('system_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_document_types', function (Blueprint $table) {
            $table->dropForeign('application_document_types_system_id_foreign');
        });
    }
}
