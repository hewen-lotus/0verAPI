<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwoYearTechDepartmentDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('two_year_tech_department_data', function (Blueprint $table) {
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
            $table->string('decrease_reason')->comment('減招原因');
            $table->boolean('self_recurit')->comment('是否有自招');
            $table->integer('self_recurit_amount')->comment('自招名額');
            $table->boolean('day_school')->comment('系所是否有二技日間部學制');
            $table->boolean('special_class')->comment('是否招收僑生專班');
            $table->boolean('special_class_foriegn')->comment('是否招收外生專班');
            $table->boolean('approve_no_of_special_class')->comment('僑生專班報部文號');
            $table->string('special_dept')->nullable()->comment('特殊系所（醫、牙、中醫、藝術）');
            $table->string('sex_limit')->nullable()->comment('性別限制');
            $table->integer('ratify')->comment('核定名額');
            $table->integer('rank')->comment('志願排名');
            $table->integer('sort_order')->comment('輸出排序');
            $table->string('after_birth')->comment('限…之後出生');
            $table->string('before_birth')->comment('限…之前出生');
            $table->string('dept_group')->comment('18大學群代碼');
            $table->string('sub_dept_group')->comment('次要18大學群代碼');
            $table->boolean('eng_taught')->comment('全英文授課');
            $table->boolean('disabilities')->comment('是否招收身障學生');
            $table->boolean('BuHweiHwaWen')->comment('是否招收不具華文基礎學生');
            $table->string('evaluation')->comment('系所評鑑等級');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['id', 'school_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('two_year_tech_department_data');
    }
}
