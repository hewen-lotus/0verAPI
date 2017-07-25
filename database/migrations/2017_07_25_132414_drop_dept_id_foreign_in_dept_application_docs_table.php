<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropDeptIdForeignInDeptApplicationDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paper_application_document_history_address', function (Blueprint $table) {
            $table->dropForeign('history_address_dept_id_foreign');
        });

        Schema::table('paper_application_document_address', function (Blueprint $table) {
            $table->dropForeign('address_dept_id_foreign');
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
