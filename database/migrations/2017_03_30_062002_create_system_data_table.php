<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_history_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->unsignedInteger('type_id')->comment('學制種類（學士, 碩士, 二技, 博士）');
            $table->foreign('type_id')->references('id')->on('system_types');
            $table->enum('action', ['save', 'commit']);
            $table->text('description')->comment('學制描述');
            $table->text('eng_description')->nullable()->comment('學制描述');
            $table->unsignedInteger('last_year_admission_amount')->nullable()->comment('僑生可招收數量（上學年新生總額 10%）（二技參照學士）');
            $table->unsignedInteger('last_year_surplus_admission_quota')->nullable()->comment('上學年本地生未招足名額（二技參照學士）');
            $table->unsignedInteger('ratify_expanded_quota')->nullable()->comment('本學年教育部核定擴增名額（二技參照學士）');
            $table->unsignedInteger('ratify_quota_for_self_enrollment')->nullable()->comment('教育部核定單獨招收名額（二技參照學士）');
            $table->unsignedInteger('ratify_quota_for_admission')->nullable()->comment('教育部核定聯招名額（二技參照學士）');
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

        Schema::create('system_data', function (Blueprint $table) {
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->unsignedInteger('type_id')->comment('學制種類（學士, 碩士, 二技, 博士）');
            $table->foreign('type_id')->references('id')->on('system_types');
            $table->text('description')->comment('學制描述');
            $table->text('eng_description')->nullable()->comment('學制描述');
            $table->unsignedInteger('last_year_admission_amount')->nullable()->comment('僑生可招收數量（上學年新生總額 10%）（二技參照學士）');
            $table->unsignedInteger('last_year_surplus_admission_quota')->nullable()->comment('上學年本地生未招足名額（二技參照學士）');
            $table->unsignedInteger('ratify_expanded_quota')->nullable()->comment('本學年教育部核定擴增名額（二技參照學士）');
            $table->unsignedInteger('ratify_quota_for_self_enrollment')->nullable()->comment('教育部核定單獨招收名額（二技參照學士）');
            $table->unsignedInteger('ratify_quota_for_admission')->nullable()->comment('教育部核定聯招名額（二技參照學士）');
            $table->string('confirmed_by')->nullable()->comment('資料由哪位海聯人員確認匯入的');
            $table->foreign('confirmed_by')->references('username')->on('users');
            $table->string('confirmed_at')->nullable()->comment('資料確認匯入的時間');
            $table->unsignedInteger('history_id')->nullable()->comment('從哪一筆歷史紀錄匯入的');
            $table->foreign('history_id')->references('history_id')->on('system_history_data');
            $table->string('created_at');
            $table->string('updated_by')->nullable()->comment('資料最後更新者');
            $table->foreign('updated_by')->references('username')->on('users');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['school_code', 'type_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_history_data', function (Blueprint $table) {
            $table->dropForeign('system_history_data_school_code_foreign');
            $table->dropForeign('system_history_data_type_id_foreign');
            $table->dropForeign('system_history_data_review_by_foreign');
            $table->dropForeign('system_history_data_created_by_foreign');
        });

        Schema::table('system_data', function (Blueprint $table) {
            $table->dropForeign('system_data_school_code_foreign');
            $table->dropForeign('system_data_type_id_foreign');
            $table->dropForeign('system_data_confirmed_by_foreign');
            $table->dropForeign('system_data_history_id_foreign');
            $table->dropForeign('system_data_updated_by_foreign');
        });

        Schema::dropIfExists('system_data');
        Schema::dropIfExists('system_history_data');
    }
}
