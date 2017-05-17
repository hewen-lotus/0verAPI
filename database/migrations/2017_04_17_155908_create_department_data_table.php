<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_data', function (Blueprint $table) {
            $table->string('id')->unique()->comment('系所代碼（系統按規則產生）');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('card_code')->unique()->comment('讀卡代碼');
            $table->string('title')->comment('系所名稱');
            $table->string('eng_title')->comment('系所英文名稱');
            $table->text('description')->comment('選系說明');
            $table->text('eng_description')->comment('選系英文說明');
            $table->text('memo')->comment('給海聯的備註');
            $table->text('eng_memo')->comment('給海聯的英文備註');
            $table->string('url')->comment('系網站網址');
            $table->string('eng_url')->comment('英文系網站網址');
            $table->unsignedInteger('last_year_admission_placement_amount')->comment('去年聯合分發錄取名額');
            $table->unsignedInteger('last_year_admission_placement_quota')->comment('去年聯合分發名額（只有學士班有聯合分發）');
            $table->unsignedInteger('admission_placement_quota')->comment('聯合分發名額（只有學士班有聯合分發）');
            $table->string('decrease_reason_of_admission_placement')->nullable()->comment('聯合分發人數減招原因');
            $table->unsignedInteger('last_year_personal_apply_offer')->comment('去年個人申請錄取名額');
            $table->unsignedInteger('last_year_personal_apply_amount')->comment('去年個人申請名額');
            $table->unsignedInteger('admission_selection_quota')->comment('個人申請名額');
            $table->boolean('has_self_enrollment')->comment('是否有自招');
            $table->unsignedInteger('self_enrollment_quota')->nullable()->comment('自招名額');
            $table->boolean('has_special_class')->comment('是否招收僑生專班');
            $table->boolean('has_foreign_special_class')->comment('是否招收外生專班');
            $table->string('special_dept_type')->nullable()->comment('特殊系所（醫、牙、中醫、藝術）');
            $table->enum('gender_limit', ['M', 'F'])->nullable()->comment('性別限制');
            $table->unsignedInteger('admission_placement_ratify_quota')->comment('教育部核定聯合分發名額');
            $table->unsignedInteger('admission_selection_ratify_quota')->comment('教育部核定個人申請名額');
            $table->unsignedInteger('rank')->default(99999)->comment('志願排名');
            $table->unsignedInteger('sort_order')->default(99999)->comment('輸出排序');
            $table->boolean('has_birth_limit')->comment('是否限制出生日期');
            $table->string('birth_limit_after')->nullable()->comment('限…之後出生');
            $table->string('birth_limit_before')->nullable()->comment('限…之前出生');
            $table->string('main_group')->comment('主要隸屬學群代碼');
            $table->string('sub_group')->nullable()->comment('次要隸屬學群代碼');
            $table->boolean('has_eng_taught')->comment('全英文授課');
            $table->boolean('has_disabilities')->comment('是否招收身障學生');
            $table->boolean('has_BuHweiHwaWen')->comment('是否招收不具華文基礎學生');
            $table->string('evaluation')->comment('系所評鑑等級');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['id', 'school_code']);
        });

        Schema::create('department_saved_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('id')->comment('系所代碼（系統按規則產生）');
            $table->foreign('id')->references('id')->on('department_data');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('card_code')->comment('讀卡代碼');
            $table->string('title')->comment('系所名稱');
            $table->string('eng_title')->comment('系所英文名稱');
            $table->text('description')->comment('選系說明');
            $table->text('eng_description')->comment('選系英文說明');
            $table->text('memo')->comment('給海聯的備註');
            $table->text('eng_memo')->comment('給海聯的英文備註');
            $table->string('url')->comment('系網站網址');
            $table->string('eng_url')->comment('英文系網站網址');
            $table->unsignedInteger('last_year_admission_placement_amount')->comment('去年聯合分發錄取名額');
            $table->unsignedInteger('last_year_admission_placement_quota')->comment('去年聯合分發名額（只有學士班有聯合分發）');
            $table->unsignedInteger('admission_placement_quota')->comment('聯合分發名額（只有學士班有聯合分發）');
            $table->string('decrease_reason_of_admission_placement')->nullable()->comment('聯合分發人數減招原因');
            $table->unsignedInteger('last_year_personal_apply_offer')->comment('去年個人申請錄取名額');
            $table->unsignedInteger('last_year_personal_apply_amount')->comment('去年個人申請名額');
            $table->unsignedInteger('admission_selection_quota')->comment('個人申請名額');
            $table->boolean('has_self_enrollment')->comment('是否有自招');
            $table->unsignedInteger('self_enrollment_quota')->nullable()->comment('自招名額');
            $table->boolean('has_special_class')->comment('是否招收僑生專班');
            $table->boolean('has_foreign_special_class')->comment('是否招收外生專班');
            $table->string('special_dept_type')->nullable()->comment('特殊系所（醫、牙、中醫、藝術）');
            $table->enum('gender_limit', ['M', 'F'])->nullable()->comment('性別限制');
            $table->unsignedInteger('admission_placement_ratify_quota')->comment('教育部核定聯合分發名額');
            $table->unsignedInteger('admission_selection_ratify_quota')->comment('教育部核定個人申請名額');
            $table->unsignedInteger('rank')->default(99999)->comment('志願排名');
            $table->unsignedInteger('sort_order')->default(99999)->comment('輸出排序');
            $table->boolean('has_birth_limit')->comment('是否限制出生日期');
            $table->string('birth_limit_after')->nullable()->comment('限…之後出生');
            $table->string('birth_limit_before')->nullable()->comment('限…之前出生');
            $table->string('main_group')->comment('主要隸屬學群代碼');
            $table->string('sub_group')->nullable()->comment('次要隸屬學群代碼');
            $table->boolean('has_eng_taught')->comment('全英文授課');
            $table->boolean('has_disabilities')->comment('是否招收身障學生');
            $table->boolean('has_BuHweiHwaWen')->comment('是否招收不具華文基礎學生');
            $table->string('evaluation')->comment('系所評鑑等級');
            $table->string('modified_by')->nullable()->comment('儲存資料的人是誰');
            $table->foreign('modified_by')->references('username')->on('users');
            $table->string('quantity_modified_by')->nullable()->comment('儲存名額的人是誰');
            $table->foreign('quantity_modified_by')->references('username')->on('users');
            $table->ipAddress('ip_address')->comment('按下儲存的人的IP');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });

        Schema::create('department_committed_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->unsignedInteger('saved_id')->comment('對應 saved 表的 id');
            $table->foreign('saved_id')->references('history_id')->on('department_saved_data');
            $table->string('id')->comment('系所代碼（系統按規則產生）');
            $table->foreign('id')->references('id')->on('department_data');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('card_code')->comment('讀卡代碼');
            $table->string('title')->comment('系所名稱');
            $table->string('eng_title')->comment('系所英文名稱');
            $table->text('description')->comment('選系說明');
            $table->text('eng_description')->comment('選系英文說明');
            $table->text('memo')->comment('給海聯的備註');
            $table->text('eng_memo')->comment('給海聯的英文備註');
            $table->string('url')->comment('系網站網址');
            $table->string('eng_url')->comment('英文系網站網址');
            $table->unsignedInteger('last_year_admission_placement_amount')->comment('去年聯合分發錄取名額');
            $table->unsignedInteger('last_year_admission_placement_quota')->comment('去年聯合分發名額（只有學士班有聯合分發）');
            $table->unsignedInteger('admission_placement_quota')->comment('聯合分發名額（只有學士班有聯合分發）');
            $table->string('decrease_reason_of_admission_placement')->nullable()->comment('聯合分發人數減招原因');
            $table->unsignedInteger('last_year_personal_apply_offer')->comment('去年個人申請錄取名額');
            $table->unsignedInteger('last_year_personal_apply_amount')->comment('去年個人申請名額');
            $table->unsignedInteger('admission_selection_quota')->comment('個人申請名額');
            $table->boolean('has_self_enrollment')->comment('是否有自招');
            $table->unsignedInteger('self_enrollment_quota')->nullable()->comment('自招名額');
            $table->boolean('has_special_class')->comment('是否招收僑生專班');
            $table->boolean('has_foreign_special_class')->comment('是否招收外生專班');
            $table->string('special_dept_type')->nullable()->comment('特殊系所（醫、牙、中醫、藝術）');
            $table->enum('gender_limit', ['M', 'F'])->nullable()->comment('性別限制');
            $table->unsignedInteger('admission_placement_ratify_quota')->comment('教育部核定聯合分發名額');
            $table->unsignedInteger('admission_selection_ratify_quota')->comment('教育部核定個人申請名額');
            $table->unsignedInteger('rank')->default(99999)->comment('志願排名');
            $table->unsignedInteger('sort_order')->default(99999)->comment('輸出排序');
            $table->boolean('has_birth_limit')->comment('是否限制出生日期');
            $table->string('birth_limit_after')->nullable()->comment('限…之後出生');
            $table->string('birth_limit_before')->nullable()->comment('限…之前出生');
            $table->string('main_group')->comment('主要隸屬學群代碼');
            $table->string('sub_group')->nullable()->comment('次要隸屬學群代碼');
            $table->boolean('has_eng_taught')->comment('全英文授課');
            $table->boolean('has_disabilities')->comment('是否招收身障學生');
            $table->boolean('has_BuHweiHwaWen')->comment('是否招收不具華文基礎學生');
            $table->string('evaluation')->comment('系所評鑑等級');
            $table->string('committed_by')->nullable()->comment('送出資料的人是誰');
            $table->foreign('committed_by')->references('username')->on('users');
            $table->string('quantity_committed_by')->nullable()->comment('送出名額的人是誰');
            $table->foreign('quantity_committed_by')->references('username')->on('users');
            $table->ipAddress('ip_address')->comment('按下送出的人的IP');
            $table->enum('quantity_review_status', ['waiting', 'confirmed', 'editing'])->default('editing')->comment('by 教育部');
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
        Schema::table('department_data', function (Blueprint $table) {
            $table->dropForeign('department_data_school_code_foreign');
        });

        Schema::table('department_saved_data', function (Blueprint $table) {
            $table->dropForeign('department_saved_data_id_foreign');
            $table->dropForeign('department_saved_data_school_code_foreign');
            $table->dropForeign('department_saved_data_modified_by_foreign');
            $table->dropForeign('department_saved_data_quantity_modified_by_foreign');
        });

        Schema::table('department_committed_data', function (Blueprint $table) {
            $table->dropForeign('department_committed_data_saved_id_foreign');
            $table->dropForeign('department_committed_data_id_foreign');
            $table->dropForeign('department_committed_data_school_code_foreign');
            $table->dropForeign('department_committed_data_committed_by_foreign');
            $table->dropForeign('department_committed_data_quantity_committed_by_foreign');
            $table->dropForeign('department_committed_data_replied_by_foreign');
            $table->dropForeign('department_committed_data_confirmed_by_foreign');
        });

        Schema::dropIfExists('department_saved_data');
        Schema::dropIfExists('department_committed_data');
        Schema::dropIfExists('department_data');
    }
}
