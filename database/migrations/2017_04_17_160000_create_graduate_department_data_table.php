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
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('title')->comment('系所名稱');
            $table->string('eng_title')->comment('系所英文名稱');
            $table->unsignedInteger('system_id')->comment('這是碩士班還是博士班 QQ');
            $table->foreign('system_id')->references('id')->on('system_types');
            $table->text('description')->comment('選系說明');
            $table->text('eng_description')->nullable()->comment('選系英文說明');
            $table->text('memo')->nullable()->comment('給海聯的備註');
            $table->string('url')->comment('系網站網址');
            $table->string('eng_url')->nullable()->comment('英文系網站網址');
            $table->unsignedInteger('last_year_personal_apply_offer')->comment('去年個人申請錄取名額');
            $table->unsignedInteger('last_year_personal_apply_amount')->comment('去年個人申請名額');
            $table->unsignedInteger('admission_selection_quota')->comment('個人申請名額');
            $table->boolean('has_self_enrollment')->comment('是否有自招');
            $table->unsignedInteger('self_enrollment_quota')->nullable()->comment('自招名額');
            $table->boolean('has_special_class')->comment('是否招收僑生專班');
            $table->boolean('has_foreign_special_class')->comment('是否招收外生專班');
            $table->string('special_dept_type')->nullable()->comment('特殊系所（醫學系、牙醫學系、中醫學系、藝術相關學系）');
            $table->enum('gender_limit', ['M', 'F'])->nullable()->comment('性別限制');
            $table->unsignedInteger('admission_selection_ratify_quota')->nullable()->comment('教育部核定個人申請名額');
            $table->unsignedInteger('self_enrollment_ratify_quota')->nullable()->comment('教育部核定單獨招收(自招)名額');
            $table->unsignedInteger('sort_order')->default(99999)->comment('輸出排序');
            $table->boolean('has_birth_limit')->comment('是否限制出生日期');
            $table->string('birth_limit_after')->nullable()->comment('限…之後出生');
            $table->string('birth_limit_before')->nullable()->comment('限…之前出生');
            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->nullable()->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->nullable()->comment('審查費用英文細節');
            $table->boolean('has_eng_taught')->comment('全英文授課');
            $table->boolean('has_disabilities')->comment('是否招收身障學生');
            $table->boolean('has_BuHweiHwaWen')->comment('是否招收不具華文基礎學生');
            $table->unsignedInteger('main_group')->comment('主要隸屬學群代碼');
            $table->foreign('main_group')->references('id')->on('department_groups');
            $table->unsignedInteger('sub_group')->nullable()->comment('次要隸屬學群代碼');
            $table->foreign('sub_group')->references('id')->on('department_groups');
            $table->unsignedInteger('evaluation')->comment('系所評鑑等級');
            $table->foreign('evaluation')->references('id')->on('evaluation_levels');
            $table->string('confirmed_by')->nullable()->comment('資料由哪位海聯人員確認匯入的');
            $table->foreign('confirmed_by')->references('username')->on('users');
            $table->string('confirmed_at')->nullable()->comment('資料確認匯入的時間');
            $table->string('created_at');
            $table->string('updated_by')->nullable()->comment('資料最後更新者');
            $table->foreign('updated_by')->references('username')->on('users');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['id', 'school_code']);
        });

        Schema::create('graduate_department_history_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('id')->comment('系所代碼（系統按規則產生）');
            $table->foreign('id')->references('id')->on('graduate_department_data');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('title')->comment('系所名稱');
            $table->string('eng_title')->comment('系所英文名稱');
            $table->unsignedInteger('system_id')->comment('這是碩士班還是博士班 QQ');
            $table->foreign('system_id')->references('id')->on('system_types');
            $table->text('description')->comment('選系說明');
            $table->text('eng_description')->nullable()->comment('選系英文說明');
            $table->text('memo')->nullable()->comment('給海聯的備註');
            $table->string('url')->comment('系網站網址');
            $table->string('eng_url')->nullable()->comment('英文系網站網址');
            $table->unsignedInteger('last_year_personal_apply_offer')->comment('去年個人申請錄取名額');
            $table->unsignedInteger('last_year_personal_apply_amount')->comment('去年個人申請名額');
            $table->unsignedInteger('admission_selection_quota')->comment('個人申請名額');
            $table->boolean('has_self_enrollment')->comment('是否有自招');
            $table->unsignedInteger('self_enrollment_quota')->nullable()->comment('自招名額');
            $table->boolean('has_special_class')->comment('是否招收僑生專班');
            $table->boolean('has_foreign_special_class')->comment('是否招收外生專班');
            $table->string('special_dept_type')->nullable()->comment('特殊系所（醫學系、牙醫學系、中醫學系、藝術相關學系）');
            $table->enum('gender_limit', ['M', 'F'])->nullable()->comment('性別限制');
            $table->unsignedInteger('admission_selection_ratify_quota')->nullable()->comment('教育部核定個人申請名額');
            $table->unsignedInteger('self_enrollment_ratify_quota')->nullable()->comment('教育部核定單獨招收(自招)名額');
            $table->unsignedInteger('sort_order')->default(99999)->comment('輸出排序');
            $table->boolean('has_birth_limit')->comment('是否限制出生日期');
            $table->string('birth_limit_after')->nullable()->comment('限…之後出生');
            $table->string('birth_limit_before')->nullable()->comment('限…之前出生');
            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->nullable()->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->nullable()->comment('審查費用英文細節');
            $table->boolean('has_eng_taught')->comment('全英文授課');
            $table->boolean('has_disabilities')->comment('是否招收身障學生');
            $table->boolean('has_BuHweiHwaWen')->comment('是否招收不具華文基礎學生');
            $table->unsignedInteger('main_group')->comment('主要隸屬學群代碼');
            $table->foreign('main_group')->references('id')->on('department_groups');
            $table->unsignedInteger('sub_group')->nullable()->comment('次要隸屬學群代碼');
            $table->foreign('sub_group')->references('id')->on('department_groups');
            $table->unsignedInteger('evaluation')->comment('系所評鑑等級');
            $table->foreign('evaluation')->references('id')->on('evaluation_levels');
            $table->ipAddress('ip_address')->comment('按下送出的人的IP');
            $table->enum('info_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('資料狀態（editing|waiting|returned|confirmed');
            $table->enum('quota_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('名額狀態（editing|waiting|returned|confirmed');
            $table->text('review_memo')->nullable()->comment('海聯審閱備註');
            $table->string('review_by')->nullable()->comment('海聯審閱人員');
            $table->foreign('review_by')->references('username')->on('users');
            $table->string('review_at')->nullable()->comment('海聯審閱的時間點');
            $table->string('created_by')->nullable()->comment('此歷史紀錄建立者');
            $table->foreign('created_by')->references('username')->on('users');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });

        Schema::table('graduate_department_data', function (Blueprint $table) {
            $table->unsignedInteger('history_id')->nullable()->comment('從哪一筆歷史紀錄匯入的');
            $table->foreign('history_id')->references('history_id')->on('graduate_department_history_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graduate_department_data', function (Blueprint $table) {
            $table->dropForeign('graduate_department_data_system_id_foreign');
            $table->dropForeign('graduate_department_data_school_code_foreign');
            $table->dropForeign('graduate_department_data_confirmed_by_foreign');
            $table->dropForeign('graduate_department_data_history_id_foreign');
            $table->dropForeign('graduate_department_data_updated_by_foreign');
            $table->dropForeign('graduate_department_data_main_group_foreign');
            $table->dropForeign('graduate_department_data_sub_group_foreign');
            $table->dropForeign('graduate_department_data_evaluation_foreign');
        });

        Schema::table('graduate_department_history_data', function (Blueprint $table) {
            $table->dropForeign('graduate_department_history_data_system_id_foreign');
            $table->dropForeign('graduate_department_history_data_id_foreign');
            $table->dropForeign('graduate_department_history_data_school_code_foreign');
            $table->dropForeign('graduate_department_history_data_review_by_foreign');
            $table->dropForeign('graduate_department_history_data_created_by_foreign');
            $table->dropForeign('graduate_department_history_data_main_group_foreign');
            $table->dropForeign('graduate_department_history_data_sub_group_foreign');
            $table->dropForeign('graduate_department_history_data_evaluation_foreign');
        });

        Schema::dropIfExists('graduate_department_history_data');
        Schema::dropIfExists('graduate_department_data');
    }
}
