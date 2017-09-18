<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperApplicationDocumentAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create_paper_application_document_address_table
        Schema::create('paper_application_document_address', function (Blueprint $table) {
            $table->string('dept_id')->comment('系所代碼'); // 三個學制混在一起記
            $table->foreign('dept_id', 'address_dept_id_foreign')->references('id')->on('department_data');
            $table->unsignedInteger('type_id')->comment('備審資料代碼（系統自動產生）');
            $table->foreign('type_id', 'address_type_id_foreign')->references('id')->on('application_document_types');
            $table->text('address');
            $table->string('recipient')->comment('收件人');
            $table->string('phone')->comment('收件人電話');
            $table->string('email')->comment('收件人 email');
            $table->string('deadline')->comment('收件截止日期');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['dept_id', 'type_id'], 'pkey');
        });

        Schema::create('paper_application_document_history_address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dept_id')->comment('系所代碼'); // 三個學制混在一起記
            $table->foreign('dept_id', 'history_address_dept_id_foreign')->references('id')->on('department_data');
            $table->unsignedInteger('type_id')->comment('備審資料代碼（系統自動產生）');
            $table->foreign('type_id', 'history_address_type_id_foreign')->references('id')->on('application_document_types');
            $table->text('address');
            $table->string('recipient')->comment('收件人');
            $table->string('phone')->comment('收件人電話');
            $table->string('email')->comment('收件人 email');
            $table->string('deadline')->comment('收件截止日期');
            $table->string('created_by')->nullable()->comment('此歷史紀錄建立者');
            $table->foreign('created_by')->references('username')->on('users');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paper_application_document_history_address', function (Blueprint $table) {
            $table->dropForeign('history_address_dept_id_foreign');
            $table->dropForeign('history_address_type_id_foreign');
        });

        Schema::table('paper_application_document_address', function (Blueprint $table) {
            $table->dropForeign('address_type_id_foreign');
            $table->dropForeign('address_dept_id_foreign');
        });

        Schema::dropIfExists('paper_application_document_address');
        Schema::dropIfExists('paper_application_document_history_address');
    }
}
