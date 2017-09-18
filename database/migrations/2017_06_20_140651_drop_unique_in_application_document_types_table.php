<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUniqueInApplicationDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_document_types', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->dropUnique(['eng_name']);
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
            $table->unique('name');
            $table->unique('eng_name');
        });
    }
}
