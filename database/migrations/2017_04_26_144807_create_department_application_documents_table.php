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
        Schema::create('department_application_documents', function (Blueprint $table) {
            $table->string('dept_id')->comment('系所代碼');
            $table->unsignedInteger('document_type_id')->comment('備審資料代碼（系統自動產生）');
            $table->text('description')->comment('詳細說明');
            $table->text('eng_description')->comment('英文的詳細說明');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['dept_id', 'document_type_id'], 'pkey');
        });

        Schema::table('department_application_documents', function (Blueprint $table) {
            $table->foreign('document_type_id')->references('id')->on('application_document_types');
            $table->foreign('dept_id')->references('id')->on('department_data');
        });

        Schema::create('department_saved_application_documents', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('dept_id')->comment('系所代碼');
            $table->foreign('dept_id')->references('id')->on('department_data');
            $table->unsignedInteger('document_type_id')->comment('備審資料代碼（系統自動產生）');
            $table->foreign('document_type_id')->references('id')->on('application_document_types');
            $table->text('description')->comment('詳細說明');
            $table->text('eng_description')->comment('英文的詳細說明');
            $table->string('modified_by')->comment('按下儲存的人是誰');
            $table->foreign('modified_by')->references('username')->on('users');
            $table->ipAddress('ip_address')->comment('按下儲存的人的IP');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });

        Schema::create('department_committed_application_documents', function (Blueprint $table) {
            $table->increments('history_id');
            $table->unsignedInteger('saved_id')->comment('對應 saved 表的 id');
            $table->foreign('saved_id')->references('history_id')->on('department_saved_application_documents');
            $table->string('dept_id')->comment('系所代碼');
            $table->foreign('dept_id')->references('id')->on('department_data');
            $table->unsignedInteger('document_type_id')->comment('備審資料代碼（系統自動產生）');
            $table->foreign('document_type_id', 'department_committed_application_documents_doc_type_id_foreign')->references('id')->on('application_document_types');
            $table->string('description')->comment('詳細說明');
            $table->string('eng_description')->comment('英文的詳細說明');
            $table->string('committed_by')->comment('按下送出的人是誰');
            $table->foreign('committed_by')->references('username')->on('users');
            $table->ipAddress('ip_address')->comment('按下送出的人的IP');
            $table->enum('review_status', ['waiting', 'confirmed', 'editing'])->default('editing')->comment('by 海聯');
            $table->text('review_memo')->nullable()->comment('讓學校再次修改的原因');
            $table->string('replied_by')->nullable()->comment('海聯回覆的人員');
            $table->foreign('replied_by')->references('username')->on('admins');
            $table->string('replied_at')->nullable()->comment('海聯回覆的時間點');
            $table->string('confirmed_by')->nullable()->comment('海聯審查的人員');
            $table->foreign('confirmed_by')->references('username')->on('admins');
            $table->string('confirmed_at')->nullable()->comment('海聯審查的時間點');
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
        Schema::table('department_application_documents', function (Blueprint $table) {
            $table->dropForeign('department_application_documents_document_type_id_foreign');
            $table->dropForeign('department_application_documents_dept_id_foreign');
        });

        Schema::table('department_saved_application_documents', function (Blueprint $table) {
            $table->dropForeign('department_saved_application_documents_document_type_id_foreign');
            $table->dropForeign('department_saved_application_documents_dept_id_foreign');
            $table->dropForeign('department_saved_application_documents_modified_by_foreign');
        });

        Schema::table('department_committed_application_documents', function (Blueprint $table) {
            $table->dropForeign('department_committed_application_documents_saved_id_foreign');
            $table->dropForeign('department_committed_application_documents_doc_type_id_foreign');
            $table->dropForeign('department_committed_application_documents_dept_id_foreign');
            $table->dropForeign('department_committed_application_documents_committed_by_foreign');
            $table->dropForeign('department_committed_application_documents_replied_by_foreign');
            $table->dropForeign('department_committed_application_documents_confirmed_by_foreign');
        });

        Schema::dropIfExists('department_committed_application_documents');
        Schema::dropIfExists('department_saved_application_documents');
        Schema::dropIfExists('department_application_documents');
    }
}
