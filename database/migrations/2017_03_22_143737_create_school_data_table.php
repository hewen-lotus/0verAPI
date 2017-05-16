<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_data', function (Blueprint $table) {
            $table->string('id')->primary()->comment('學校代碼');
            $table->string('title')->comment('學校名稱');
            $table->string('eng_title')->comment('學校英文名稱');
            $table->string('address')->comment('學校地址');
            $table->string('eng_address')->comment('學校英文地址');
            $table->string('organization')->comment('學校負責僑生事務的承辦單位名稱');
            $table->string('eng_organization')->comment('學校負責僑生事務的承辦單位英文名稱');
            $table->text('dorm_info')->comment('宿舍說明');
            $table->text('eng_dorm_info')->comment('宿舍英文說明');
            $table->string('url')->comment('學校網站網址');
            $table->string('eng_url')->comment('學校英文網站網址');
            $table->string('type')->comment('「公、私立」與「大學、科大」之組合＋「僑先部」共五種');
            $table->string('phone')->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->string('fax')->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->integer('sort_order')->comment('學校顯示排序（教育部給）');
            $table->boolean('scholarship')->comment('是否提供僑生專屬獎學金');
            $table->string('scholarship_url')->nullable()->comment('僑生專屬獎學金說明網址');
            $table->string('eng_scholarship_url')->nullable()->comment('僑生專屬獎學金英文說明網址');
            $table->string('scholarship_dept')->nullable()->comment('獎學金負責單位名稱');
            $table->string('eng_scholarship_dept')->nullable()->comment('獎學金負責單位英文名稱');
            $table->boolean('five_year_allowed')->comment('[中五]我可以招呢');
            $table->string('five_year_rule')->nullable()->comment('[中五]給海聯看的學則');
            $table->string('approve_no_of_independent_recruitment')->nullable()->comment('自招核定文號');
            $table->string('approval_document_of_independent_recruitment')->nullable()->comment('自招核定公文電子檔(file path)');
            $table->unsignedInteger('self_limit')->nullable()->comment('自招總額');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });

        Schema::create('school_saved_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('id')->comment('學校代碼');
            $table->foreign('id')->references('id')->on('school_data');
            $table->string('title')->nullable()->comment('學校名稱');
            $table->string('eng_title')->nullable()->comment('學校英文名稱');
            $table->string('address')->nullable()->comment('學校地址');
            $table->string('eng_address')->nullable()->comment('學校英文地址');
            $table->string('organization')->nullable()->comment('學校負責僑生事務的承辦單位名稱');
            $table->string('eng_organization')->nullable()->comment('學校負責僑生事務的承辦單位英文名稱');
            $table->text('dorm_info')->nullable()->comment('宿舍說明');
            $table->text('eng_dorm_info')->nullable()->comment('宿舍英文說明');
            $table->string('url')->nullable()->comment('學校網站網址');
            $table->string('eng_url')->nullable()->comment('學校英文網站網址');
            $table->string('type')->nullable()->comment('「公、私立」與「大學、科大」之組合＋「僑先部」共五種');
            $table->string('phone')->nullable()->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->string('fax')->nullable()->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->integer('sort_order')->nullable()->comment('學校顯示排序（教育部給）');
            $table->boolean('scholarship')->nullable()->comment('是否提供僑生專屬獎學金');
            $table->string('scholarship_url')->nullable()->comment('僑生專屬獎學金說明網址');
            $table->string('eng_scholarship_url')->nullable()->comment('僑生專屬獎學金英文說明網址');
            $table->string('scholarship_dept')->nullable()->comment('獎學金負責單位名稱');
            $table->string('eng_scholarship_dept')->nullable()->comment('獎學金負責單位英文名稱');
            $table->boolean('five_year_allowed')->nullable()->comment('[中五]我可以招呢');
            $table->string('five_year_rule')->nullable()->comment('[中五]給海聯看的學則');
            $table->string('approve_no_of_independent_recruitment')->nullable()->comment('自招核定文號');
            $table->string('approval_document_of_independent_recruitment')->nullable()->comment('自招核定公文電子檔(file path)');
            $table->unsignedInteger('self_limit')->nullable()->comment('自招總額');
            $table->string('modified_by')->comment('按下儲存的人是誰');
            $table->foreign('modified_by')->references('username')->on('users');
            $table->string('ip_address')->comment('按下儲存的人的IP');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });

        Schema::create('school_committed_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->integer('saved_id')->unsigned()->unsigned()->comment('對應 saved 表的 id');
            $table->foreign('saved_id')->references('history_id')->on('school_saved_data');
            $table->string('id')->comment('學校代碼');
            $table->foreign('id')->references('id')->on('school_data');
            $table->string('title')->comment('學校名稱');
            $table->string('eng_title')->comment('學校英文名稱');
            $table->string('address')->comment('學校地址');
            $table->string('eng_address')->comment('學校英文地址');
            $table->string('organization')->comment('學校負責僑生事務的承辦單位名稱');
            $table->string('eng_organization')->comment('學校負責僑生事務的承辦單位英文名稱');
            $table->text('dorm_info')->comment('宿舍說明');
            $table->text('eng_dorm_info')->comment('宿舍英文說明');
            $table->string('url')->comment('學校網站網址');
            $table->string('eng_url')->comment('學校英文網站網址');
            $table->string('type')->comment('「公、私立」與「大學、科大」之組合＋「僑先部」共五種');
            $table->string('phone')->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->string('fax')->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->integer('sort_order')->comment('學校顯示排序（教育部給）');
            $table->boolean('scholarship')->comment('是否提供僑生專屬獎學金');
            $table->string('scholarship_url')->nullable()->comment('僑生專屬獎學金說明網址');
            $table->string('eng_scholarship_url')->nullable()->comment('僑生專屬獎學金英文說明網址');
            $table->string('scholarship_dept')->nullable()->comment('獎學金負責單位名稱');
            $table->string('eng_scholarship_dept')->nullable()->comment('獎學金負責單位英文名稱');
            $table->boolean('five_year_allowed')->comment('[中五]我可以招呢');
            $table->string('five_year_rule')->nullable()->comment('[中五]給海聯看的學則');
            $table->string('approve_no_of_independent_recruitment')->nullable()->comment('自招核定文號');
            $table->string('approval_document_of_independent_recruitment')->nullable()->comment('自招核定公文電子檔(file path)');
            $table->unsignedInteger('self_limit')->nullable()->comment('自招總額');
            $table->string('committed_by')->comment('按下送出的人是誰');
            $table->foreign('committed_by')->references('username')->on('users');
            $table->string('ip_address')->comment('按下送出的人的IP');
            $table->string('review_status')->comment('waiting|confirmed|editing');
            $table->string('reason')->nullable()->comment('讓學校再次修改的原因');
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
        Schema::table('school_saved_data', function (Blueprint $table) {
            $table->dropForeign('school_saved_data_id_foreign');
            $table->dropForeign('school_saved_data_modified_by_foreign');
        });

        Schema::table('school_committed_data', function (Blueprint $table) {
            $table->dropForeign('school_committed_data_saved_id_foreign');
            $table->dropForeign('school_committed_data_id_foreign');
            $table->dropForeign('school_committed_data_committed_by_foreign');
            $table->dropForeign('school_committed_data_replied_by_foreign');
            $table->dropForeign('school_committed_data_confirmed_by_foreign');
        });

        Schema::dropIfExists('school_saved_data');
        Schema::dropIfExists('school_committed_data');
        Schema::dropIfExists('school_data');
    }
}
