<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('name');
            $table->string('eng_name');
            $table->string('phone')->comment('聯絡電話');
            $table->string('last_login_at')->nullable()->comment('上次登入時間');
            $table->string('created_at');
            $table->string('created_by')->nullable();
            $table->string('updated_at');
            $table->string('updated_by')->nullable();
            $table->string('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->rememberToken();
        });

        Schema::create('school_editors', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->foreign('username')->references('username')->on('users');
            $table->string('school_code')->comment('該使用者所屬學校代碼');
            $table->string('organization')->comment('該使用者所屬單位名稱');
            $table->boolean('has_admin')->default(0);
            $table->string('last_action_at')->nullable()->comment('上次動作時間');
            $table->string('created_at');
            $table->string('created_by')->nullable();
            $table->foreign('created_by')->references('username')->on('users');
            $table->string('updated_at');
            $table->string('updated_by')->nullable();
            $table->foreign('updated_by')->references('username')->on('users');
            $table->string('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('username')->on('users');
        });

        Schema::create('school_reviewers', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->foreign('username')->references('username')->on('users');
            $table->string('school_code')->comment('該使用者所屬學校代碼');
            $table->string('organization')->comment('該使用者所屬單位名稱');
            $table->boolean('has_admin')->default(0);
            $table->string('last_action_at')->nullable()->comment('上次動作時間');
            $table->string('created_at');
            $table->string('created_by')->nullable();
            $table->foreign('created_by')->references('username')->on('users');
            $table->string('updated_at');
            $table->string('updated_by')->nullable();
            $table->foreign('updated_by')->references('username')->on('users');
            $table->string('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('username')->on('users');
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->foreign('username')->references('username')->on('users');
            $table->boolean('has_admin')->default(0);
            $table->string('last_action_at')->nullable()->comment('上次動作時間');
            $table->string('created_at');
            $table->string('created_by')->nullable();
            $table->foreign('created_by')->references('username')->on('users');
            $table->string('updated_at');
            $table->string('updated_by')->nullable();
            $table->foreign('updated_by')->references('username')->on('users');
            $table->string('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('username')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_editors', function (Blueprint $table) {
            $table->dropForeign('school_editors_username_foreign');
            $table->dropForeign('school_editors_created_by_foreign');
            $table->dropForeign('school_editors_updated_by_foreign');
            $table->dropForeign('school_editors_deleted_by_foreign');
        });

        Schema::table('school_reviewers', function (Blueprint $table) {
            $table->dropForeign('school_reviewers_username_foreign');
            $table->dropForeign('school_reviewers_created_by_foreign');
            $table->dropForeign('school_reviewers_updated_by_foreign');
            $table->dropForeign('school_reviewers_deleted_by_foreign');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign('admins_username_foreign');
            $table->dropForeign('admins_created_by_foreign');
            $table->dropForeign('admins_updated_by_foreign');
            $table->dropForeign('admins_deleted_by_foreign');
        });

        Schema::dropIfExists('admins');

        Schema::dropIfExists('school_editors');

        Schema::dropIfExists('school_reviewers');

        Schema::dropIfExists('users');
    }
}
