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
        // 紀錄第一階段名額調查
        Schema::create('system_quota', function (Blueprint $table) {
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->unsignedInteger('type_id')->comment('學制種類（學士, 碩士, 博士）');
            $table->foreign('type_id')->references('id')->on('system_types');
            $table->unsignedInteger('last_year_admission_amount')->comment('上學年度核定日間學制招生名額外加 10% 名額');
            $table->unsignedInteger('last_year_surplus_admission_quota')->nullable()->comment('上學年度本地生招生缺額數');
            $table->unsignedInteger('expanded_quota')->nullable()->comment('欲申請擴增名額');
            $table->unsignedInteger('self_enrollment_quota')->nullable()->comment('單獨招收名額');
            $table->unsignedInteger('admission_quota')->nullable()->comment('海外聯合招生管道名額');
            $table->ipAddress('ip_address')->nullable()->comment('儲存人的IP');
            $table->string('updated_by')->nullable()->comment('儲存人');
            $table->foreign('updated_by')->references('username')->on('users');
            $table->string('created_at');
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
        Schema::table('system_quota', function (Blueprint $table) {
            $table->dropForeign('system_quota_school_code_foreign');
            $table->dropForeign('system_quota_type_id_foreign');
            $table->dropForeign('system_quota_updated_by_foreign');
        });

        Schema::dropIfExists('system_quota');
    }
}
