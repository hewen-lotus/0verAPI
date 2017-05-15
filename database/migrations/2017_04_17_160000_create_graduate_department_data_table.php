<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraduateDepartmentDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduate_department_data', function (Blueprint $table) {
            $table->string('id')->unique()->comment('系所代碼（系統按規則產生）');
            $table->string('school_code')->comment('學校代碼');
            $table->string('title')->comment('系所名稱');
            $table->string('eng_title')->comment('系所英文名稱');
            $table->text('choice_memo')->comment('選系說明');
            $table->text('eng_choice_memo')->comment('選系英文說明');
            $table->text('doc_memo')->comment('書審說明');
            $table->text('eng_doc_memo')->comment('書審英文說明');
            $table->text('dept_memo')->comment('備註');
            $table->text('eng_dept_memo')->comment('英文備註');
            $table->string('url')->comment('系網站網址');
            $table->string('eng_url')->comment('英文系網站網址');
            $table->integer('last_year_personal_apply_offer')->comment('去年個人申請錄取名額');
            $table->integer('last_year_personal_apply_amount')->comment('去年個人申請名額');
            $table->integer('personal_apply_amount')->comment('個人申請名額');
            $table->string('decrease_reason')->nullable()->comment('減招原因');
            $table->boolean('self_recurit')->comment('是否有自招');
            $table->integer('self_recurit_amount')->nullable()->comment('自招名額');
            $table->boolean('special_class')->comment('是否招收僑生專班');
            $table->boolean('special_class_foriegn')->comment('是否招收外生專班');
            $table->string('special_dept')->nullable()->comment('特殊系所（醫、牙、中醫、藝術）');
            $table->string('sex_limit')->nullable()->comment('性別限制');
            $table->integer('ratify')->comment('核定名額');
            $table->integer('sort_order')->comment('輸出排序');
            $table->string('after_birth')->nullable()->comment('限…之後出生');
            $table->string('before_birth')->nullable()->comment('限…之前出生');
            $table->string('dept_group')->comment('18大學群代碼');
            $table->string('sub_dept_group')->nullable()->comment('次要18大學群代碼');
            $table->boolean('eng_taught')->comment('全英文授課');
            $table->boolean('disabilities')->comment('是否招收身障學生');
            $table->boolean('BuHweiHwaWen')->comment('是否招收不具華文基礎學生');
            $table->string('evaluation')->comment('系所評鑑等級');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['id', 'school_code']);
        });

        Schema::create('graduate_department_saved_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('id')->comment('系所代碼（系統按規則產生）');
            $table->foreign('id')->references('id')->on('graduate_department_data');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('title')->nullable()->comment('系所名稱');
            $table->string('eng_title')->nullable()->comment('系所英文名稱');
            $table->text('choice_memo')->nullable()->comment('選系說明');
            $table->text('eng_choice_memo')->nullable()->comment('選系英文說明');
            $table->text('doc_memo')->nullable()->comment('書審說明');
            $table->text('eng_doc_memo')->nullable()->comment('書審英文說明');
            $table->text('dept_memo')->nullable()->comment('備註');
            $table->text('eng_dept_memo')->nullable()->comment('英文備註');
            $table->string('url')->nullable()->comment('系網站網址');
            $table->string('eng_url')->nullable()->comment('英文系網站網址');
            $table->integer('last_year_personal_apply_offer')->nullable()->comment('去年個人申請錄取名額');
            $table->integer('last_year_personal_apply_amount')->nullable()->comment('去年個人申請名額');
            $table->integer('personal_apply_amount')->nullable()->comment('個人申請名額');
            $table->string('decrease_reason')->nullable()->comment('減招原因');
            $table->boolean('self_recurit')->nullable()->comment('是否有自招');
            $table->integer('self_recurit_amount')->nullable()->comment('自招名額');
            $table->boolean('special_class')->nullable()->comment('是否招收僑生專班');
            $table->boolean('special_class_foriegn')->nullable()->comment('是否招收外生專班');
            $table->string('special_dept')->nullable()->comment('特殊系所（醫、牙、中醫、藝術）');
            $table->string('sex_limit')->nullable()->comment('性別限制');
            $table->integer('ratify')->nullable()->comment('核定名額');
            $table->integer('sort_order')->nullable()->comment('輸出排序');
            $table->string('after_birth')->nullable()->comment('限…之後出生');
            $table->string('before_birth')->nullable()->comment('限…之前出生');
            $table->string('dept_group')->nullable()->comment('18大學群代碼');
            $table->string('sub_dept_group')->nullable()->comment('次要18大學群代碼');
            $table->boolean('eng_taught')->nullable()->comment('全英文授課');
            $table->boolean('disabilities')->nullable()->comment('是否招收身障學生');
            $table->boolean('BuHweiHwaWen')->nullable()->comment('是否招收不具華文基礎學生');
            $table->string('evaluation')->nullable()->comment('系所評鑑等級');
            $table->string('modified_by')->comment('按下儲存的人是誰');
            $table->foreign('modified_by')->references('username')->on('users');
            $table->string('ip_address')->comment('按下儲存的人的IP');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });

        Schema::create('graduate_department_committed_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('id')->comment('系所代碼（系統按規則產生）');
            $table->foreign('id')->references('id')->on('graduate_department_data');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('title')->comment('系所名稱');
            $table->string('eng_title')->comment('系所英文名稱');
            $table->text('choice_memo')->comment('選系說明');
            $table->text('eng_choice_memo')->comment('選系英文說明');
            $table->text('doc_memo')->comment('書審說明');
            $table->text('eng_doc_memo')->comment('書審英文說明');
            $table->text('dept_memo')->comment('備註');
            $table->text('eng_dept_memo')->comment('英文備註');
            $table->string('url')->comment('系網站網址');
            $table->string('eng_url')->comment('英文系網站網址');
            $table->integer('last_year_personal_apply_offer')->comment('去年個人申請錄取名額');
            $table->integer('last_year_personal_apply_amount')->comment('去年個人申請名額');
            $table->integer('personal_apply_amount')->comment('個人申請名額');
            $table->string('decrease_reason')->nullable()->comment('減招原因');
            $table->boolean('self_recurit')->comment('是否有自招');
            $table->integer('self_recurit_amount')->nullable()->comment('自招名額');
            $table->boolean('special_class')->comment('是否招收僑生專班');
            $table->boolean('special_class_foriegn')->comment('是否招收外生專班');
            $table->string('special_dept')->nullable()->comment('特殊系所（醫、牙、中醫、藝術）');
            $table->string('sex_limit')->nullable()->comment('性別限制');
            $table->integer('ratify')->comment('核定名額');
            $table->integer('sort_order')->comment('輸出排序');
            $table->string('after_birth')->nullable()->comment('限…之後出生');
            $table->string('before_birth')->nullable()->comment('限…之前出生');
            $table->string('dept_group')->comment('18大學群代碼');
            $table->string('sub_dept_group')->nullable()->comment('次要18大學群代碼');
            $table->boolean('eng_taught')->comment('全英文授課');
            $table->boolean('disabilities')->comment('是否招收身障學生');
            $table->boolean('BuHweiHwaWen')->comment('是否招收不具華文基礎學生');
            $table->string('evaluation')->comment('系所評鑑等級');
            $table->string('committed_by')->comment('按下送出的人是誰');
            $table->foreign('committed_by')->references('username')->on('users');
            $table->string('ip_address')->comment('按下送出的人的IP');
            $table->string('review_status')->comment('waiting|confirmed|editing');
            $table->string('reason')->nullable()->comment('讓學校再次修改的原因');
            $table->string('replied_by')->comment('海聯回覆的人員');
            $table->foreign('replied_by')->references('username')->on('admins');
            $table->string('replied_at')->comment('海聯回覆的時間點');
            $table->string('confirmed_by')->comment('海聯審查的人員');
            $table->foreign('confirmed_by')->references('username')->on('admins');
            $table->string('confirmed_at')->comment('海聯審查的時間點');
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
        Schema::table('graduate_department_saved_data', function (Blueprint $table) {
            $table->dropForeign('graduate_department_saved_data_id_foreign');
            $table->dropForeign('graduate_department_saved_data_school_code_foreign');
        });

        Schema::table('graduate_department_committed_data', function (Blueprint $table) {
            $table->dropForeign('graduate_department_committed_data_id_foreign');
            $table->dropForeign('graduate_department_committed_data_school_code_foreign');
        });

        Schema::dropIfExists('graduate_department_saved_data');
        Schema::dropIfExists('graduate_department_committed_data');
        Schema::dropIfExists('graduate_department_data');
    }
}
