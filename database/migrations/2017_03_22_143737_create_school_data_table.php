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
            $table->boolean('has_dorm')->default(false)->comment('是否提供宿舍');
            $table->text('dorm_info')->nullable()->comment('宿舍說明');
            $table->text('eng_dorm_info')->nullable()->comment('宿舍英文說明');
            $table->string('url')->comment('學校網站網址');
            $table->string('eng_url')->comment('學校英文網站網址');
            $table->enum('type', ['國立大學', '私立大學', '國立科技大學', '私立科技大學', '僑生先修部'])->comment('「公、私立」與「大學、科大」之組合＋「僑先部」共五種');
            $table->string('phone')->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->string('fax')->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->integer('sort_order')->comment('學校顯示排序（教育部給）');
            $table->boolean('has_scholarship')->default(false)->comment('是否提供僑生專屬獎學金');
            $table->string('scholarship_url')->nullable()->comment('僑生專屬獎學金說明網址');
            $table->string('eng_scholarship_url')->nullable()->comment('僑生專屬獎學金英文說明網址');
            $table->string('scholarship_dept')->nullable()->comment('獎學金負責單位名稱');
            $table->string('eng_scholarship_dept')->nullable()->comment('獎學金負責單位英文名稱');
            $table->boolean('has_five_year_student_allowed')->default(false)->comment('[中五]我可以招呢');
            $table->text('rule_of_five_year_student')->nullable()->comment('[中五]給海聯看的學則');
            $table->string('rule_doc_of_five_year_student')->nullable()->comment('[中五]學則文件電子擋(file path)');
            $table->boolean('has_self_enrollment')->default(false)->comment('[自招]是否單獨招收僑生');
            $table->string('approval_no_of_self_enrollment')->nullable()->comment('[自招]核定文號');
            $table->string('approval_doc_of_self_enrollment')->nullable()->comment('[自招]核定公文電子檔(file path)');
            $table->string('confirmed_by')->nullable()->comment('資料由哪位海聯人員確認匯入的');
            $table->foreign('confirmed_by')->references('username')->on('users');
            $table->string('confirmed_at')->nullable()->comment('資料確認匯入的時間');
            $table->string('created_at');
            $table->string('updated_by')->nullable()->comment('資料最後更新者');
            $table->foreign('updated_by')->references('username')->on('users');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });

        Schema::create('school_history_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('id')->comment('學校代碼');
            $table->foreign('id')->references('id')->on('school_data');
            $table->enum('action', ['save', 'commit']);
            $table->string('title')->comment('學校名稱');
            $table->string('eng_title')->comment('學校英文名稱');
            $table->string('address')->comment('學校地址');
            $table->string('eng_address')->comment('學校英文地址');
            $table->string('organization')->comment('學校負責僑生事務的承辦單位名稱');
            $table->string('eng_organization')->comment('學校負責僑生事務的承辦單位英文名稱');
            $table->boolean('has_dorm')->default(false)->comment('是否提供宿舍');
            $table->text('dorm_info')->nullable()->comment('宿舍說明');
            $table->text('eng_dorm_info')->nullable()->comment('宿舍英文說明');
            $table->string('url')->comment('學校網站網址');
            $table->string('eng_url')->comment('學校英文網站網址');
            $table->enum('type', ['國立大學', '私立大學', '國立科技大學', '私立科技大學', '僑生先修部'])->comment('「公、私立」與「大學、科大」之組合＋「僑先部」共五種');
            $table->string('phone')->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->string('fax')->comment('學校聯絡電話（+886-49-2910960#1234）');
            $table->integer('sort_order')->comment('學校顯示排序（教育部給）');
            $table->boolean('has_scholarship')->default(false)->comment('是否提供僑生專屬獎學金');
            $table->string('scholarship_url')->nullable()->comment('僑生專屬獎學金說明網址');
            $table->string('eng_scholarship_url')->nullable()->comment('僑生專屬獎學金英文說明網址');
            $table->string('scholarship_dept')->nullable()->comment('獎學金負責單位名稱');
            $table->string('eng_scholarship_dept')->nullable()->comment('獎學金負責單位英文名稱');
            $table->boolean('has_five_year_student_allowed')->default(false)->comment('[中五]我可以招呢');
            $table->text('rule_of_five_year_student')->nullable()->comment('[中五]給海聯看的學則');
            $table->string('rule_doc_of_five_year_student')->nullable()->comment('[中五]學則文件電子擋(file path)');
            $table->boolean('has_self_enrollment')->default(false)->comment('[自招]是否單獨招收僑生');
            $table->string('approval_no_of_self_enrollment')->nullable()->comment('[自招]核定文號');
            $table->string('approval_doc_of_self_enrollment')->nullable()->comment('[自招]核定公文電子檔(file path)');
            $table->ipAddress('ip_address')->comment('按下送出的人的IP');
            $table->enum('info_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('資料狀態（editing|waiting|returned|confirmed');
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

        Schema::table('school_data', function (Blueprint $table) {
            $table->unsignedInteger('history_id')->nullable()->comment('從哪一筆歷史紀錄匯入的');
            $table->foreign('history_id')->references('history_id')->on('school_history_data');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('school_history_data', function (Blueprint $table) {
            $table->dropForeign('school_history_data_id_foreign');
            $table->dropForeign('school_history_data_review_by_foreign');
            $table->dropForeign('school_history_data_created_by_foreign');
        });

        Schema::table('school_data', function (Blueprint $table) {
            $table->dropForeign('school_data_confirmed_by_foreign');
            $table->dropForeign('school_data_history_id_foreign');
            $table->dropForeign('school_data_updated_by_foreign');
        });

        Schema::dropIfExists('school_data');
        Schema::dropIfExists('school_history_data');

    }
}
