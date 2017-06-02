<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemQuotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_quota', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->unsignedInteger('type_id')->comment('學制種類（學士, 碩士, 博士）');
            $table->foreign('type_id')->references('id')->on('system_types');
            $table->enum('action', ['save', 'commit']);
            $table->unsignedInteger('last_year_admission_amount')->comment('上學年度核定日間學制招生名額外加 10% 名額');
            $table->unsignedInteger('last_year_surplus_admission_quota')->comment('上學年度本地生招生缺額數');
            $table->unsignedInteger('expanded_quota')->comment('欲申請擴增名額');
            $table->unsignedInteger('self_enrollment_quota')->comment('單獨招收名額');
            $table->unsignedInteger('admission_quota')->comment('海外聯合招生管道名額');
            $table->ipAddress('ip_address')->comment('按下送出的人的IP');
            $table->enum('status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('資料狀態（editing|waiting|returned|confirmed');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('system_quota', function (Blueprint $table) {
            $table->dropForeign('system_quota_school_code_foreign');
            $table->dropForeign('system_quota_type_id_foreign');
            $table->dropForeign('system_quota_review_by_foreign');
            $table->dropForeign('system_quota_created_by_foreign');
        });

        Schema::dropIfExists('system_quota');

    }
}
