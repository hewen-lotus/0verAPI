<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentApplicationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dept_application_docs', function (Blueprint $table) {
            $table->string('dept_id')->comment('系所代碼');
            $table->foreign('dept_id')->references('id')->on('department_data');
            $table->unsignedInteger('type_id')->comment('備審資料代碼（系統自動產生）');
            $table->foreign('type_id')->references('id')->on('application_document_types');
            $table->text('description')->comment('詳細說明');
            $table->text('eng_description')->comment('英文的詳細說明');
            $table->boolean('modifiable')->default(false)->comment('學校是否可修改此備審資料');
            $table->boolean('required')->default(false)->comment('備審資料是否為必繳');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['dept_id', 'type_id'], 'pkey');
        });

        Schema::create('dept_history_application_docs', function (Blueprint $table) {
            $table->string('dept_id')->comment('系所代碼');
            $table->foreign('dept_id')->references('id')->on('department_data');
            $table->unsignedInteger('type_id')->comment('備審資料代碼（系統自動產生）');
            $table->foreign('type_id')->references('id')->on('application_document_types');
            $table->unsignedInteger('history_id')->comment('所隸屬的系所歷史資料代碼');
            $table->foreign('history_id')->references('history_id')->on('department_history_data');
            $table->string('description')->comment('詳細說明');
            $table->string('eng_description')->comment('英文的詳細說明');
            $table->boolean('modifiable')->default(false)->comment('學校是否可修改此備審資料');
            $table->boolean('required')->default(false)->comment('備審資料是否為必繳');
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
        Schema::table('dept_application_docs', function (Blueprint $table) {
            $table->dropForeign('dept_application_docs_dept_id_foreign');
            $table->dropForeign('dept_application_docs_type_id_foreign');
        });

        Schema::table('dept_history_application_docs', function (Blueprint $table) {
            $table->dropForeign('dept_history_application_docs_type_id_foreign');
            $table->dropForeign('dept_history_application_docs_dept_id_foreign');
            $table->dropForeign('dept_history_application_docs_history_id_foreign');
        });

        Schema::dropIfExists('dept_application_docs');
        Schema::dropIfExists('dept_history_application_docs');
    }
}
