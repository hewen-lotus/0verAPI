<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwoYearTechDepartmentApplicationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('two_year_tech_department_application_documents', function (Blueprint $table) {
            $table->string('dept_id');
            $table->unsignedInteger('document_type_id');
            $table->string('detail');
            $table->string('eng_detail');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['dept_id', 'document_type_id'], 'pkey');
        });

        Schema::table('two_year_tech_department_application_documents', function (Blueprint $table) {
            $table->foreign('document_type_id', 'two_year_tech_type_foreign')->references('id')->on('application_document_types');
            $table->foreign('dept_id', 'two_year_tech_id_foreign')->references('id')->on('two_year_tech_department_data');
        });

        Schema::create('two_year_tech_department_saved_application_documents', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('dept_id')->comment('系所代碼');
            $table->foreign('dept_id', 'two_year_tech_saved_id_foreign')->references('id')->on('department_data');
            $table->unsignedInteger('document_type_id')->comment('備審資料代碼（系統自動產生）');
            $table->foreign('document_type_id', 'two_year_tech_saved_type_foreign')->references('id')->on('application_document_types');
            $table->string('detail')->nullable()->comment('詳細說明');
            $table->string('eng_detail')->nullable()->comment('英文的詳細說明');
            $table->string('modified_by')->comment('按下儲存的人是誰');
            $table->foreign('modified_by', 'two_year_tech_saved_modified_by_foreign')->references('username')->on('users');
            $table->string('ip_address')->comment('按下儲存的人的IP');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });

        Schema::create('two_year_tech_department_committed_application_documents', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('dept_id')->comment('系所代碼');
            $table->foreign('dept_id', 'two_year_tech_committed_id_foreign')->references('id')->on('department_data');
            $table->unsignedInteger('document_type_id')->comment('備審資料代碼（系統自動產生）');
            $table->foreign('document_type_id', 'two_year_tech_committed_type_foreign')->references('id')->on('application_document_types');
            $table->string('detail')->nullable()->comment('詳細說明');
            $table->string('eng_detail')->nullable()->comment('英文的詳細說明');
            $table->string('committed_by')->comment('按下送出的人是誰');
            $table->foreign('committed_by', 'two_year_tech_committed_modified_by_foreign')->references('username')->on('users');
            $table->string('ip_address')->comment('按下送出的人的IP');
            $table->string('review_status')->comment('waiting|confirmed|editing');
            $table->string('reason')->nullable()->comment('讓學校再次修改的原因');
            $table->string('replied_by')->nullable()->comment('海聯回覆的人員');
            $table->foreign('replied_by', 'two_year_tech_committed_replied_by_foreign')->references('username')->on('admins');
            $table->string('replied_at')->nullable()->comment('海聯回覆的時間點');
            $table->string('confirmed_by')->nullable()->comment('海聯審查的人員');
            $table->foreign('confirmed_by', 'two_year_tech_committed_confirmed_by_foreign')->references('username')->on('admins');
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
        Schema::table('two_year_tech_department_application_documents', function (Blueprint $table) {
            $table->dropForeign('two_year_tech_type_foreign');
            $table->dropForeign('two_year_tech_id_foreign');
        });

        Schema::table('two_year_tech_department_saved_application_documents', function (Blueprint $table) {
            $table->dropForeign('two_year_tech_saved_id_foreign');
            $table->dropForeign('two_year_tech_saved_type_foreign');
            $table->dropForeign('two_year_tech_saved_modified_by_foreign');
        });

        Schema::table('two_year_tech_department_committed_application_documents', function (Blueprint $table) {
            $table->dropForeign('two_year_tech_committed_id_foreign');
            $table->dropForeign('two_year_tech_committed_type_foreign');
            $table->dropForeign('two_year_tech_committed_modified_by_foreign');
            $table->dropForeign('two_year_tech_committed_replied_by_foreign');
            $table->dropForeign('two_year_tech_committed_confirmed_by_foreign');
        });

        Schema::dropIfExists('two_year_tech_department_committed_application_documents');
        Schema::dropIfExists('two_year_tech_department_saved_application_documents');
        Schema::dropIfExists('two_year_tech_department_application_documents');
    }
}
