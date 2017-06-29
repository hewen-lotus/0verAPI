<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorDoNotLock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_history_data', function (Blueprint $table) {
            $table->dropColumn('action');
            $table->dropColumn('info_status');
            $table->dropColumn('review_memo');
            $table->dropForeign('school_history_data_review_by_foreign');
            $table->dropColumn('review_by');
            $table->dropColumn('review_at');
        });

        Schema::table('system_history_data', function (Blueprint $table) {
            $table->dropColumn('action');
            $table->dropColumn('info_status');
            $table->dropColumn('quota_status');
            $table->dropColumn('review_memo');
            $table->dropForeign('system_history_data_review_by_foreign');
            $table->dropColumn('review_by');
            $table->dropColumn('review_at');
        });

        Schema::table('department_history_data', function (Blueprint $table) {
            $table->dropColumn('action');
            $table->dropColumn('info_status');
            $table->dropColumn('quota_status');
            $table->dropColumn('review_memo');
            $table->dropForeign('department_history_data_review_by_foreign');
            $table->dropColumn('review_by');
            $table->dropColumn('review_at');
        });

        Schema::table('two_year_tech_department_history_data', function (Blueprint $table) {
            $table->dropColumn('info_status');
            $table->dropColumn('quota_status');
            $table->dropColumn('review_memo');
            $table->dropForeign('two_year_tech_department_history_data_review_by_foreign');
            $table->dropColumn('review_by');
            $table->dropColumn('review_at');
        });

        Schema::table('graduate_department_history_data', function (Blueprint $table) {
            $table->dropColumn('info_status');
            $table->dropColumn('quota_status');
            $table->dropColumn('review_memo');
            $table->dropForeign('graduate_department_history_data_review_by_foreign');
            $table->dropColumn('review_by');
            $table->dropColumn('review_at');
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
            $table->enum('action', ['save', 'commit']);
            $table->enum('info_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('資料狀態（editing|waiting|returned|confirmed');
            $table->text('review_memo')->nullable()->comment('海聯審閱備註');
            $table->string('review_by')->nullable()->comment('海聯審閱人員');
            $table->foreign('review_by')->references('username')->on('users');
            $table->string('review_at')->nullable()->comment('海聯審閱的時間點');
        });

        Schema::table('system_history_data', function (Blueprint $table) {
            $table->enum('action', ['save', 'commit']);
            $table->enum('info_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('資料狀態（editing|waiting|returned|confirmed');
            $table->enum('quota_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('名額狀態（editing|waiting|returned|confirmed');
            $table->text('review_memo')->nullable()->comment('海聯審閱備註');
            $table->string('review_by')->nullable()->comment('海聯審閱人員');
            $table->foreign('review_by')->references('username')->on('users');
            $table->string('review_at')->nullable()->comment('海聯審閱的時間點');
        });

        Schema::table('department_history_data', function (Blueprint $table) {
            $table->enum('action', ['save', 'commit']);
            $table->enum('info_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('資料狀態（editing|waiting|returned|confirmed');
            $table->enum('quota_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('名額狀態（editing|waiting|returned|confirmed');
            $table->text('review_memo')->nullable()->comment('海聯審閱備註');
            $table->string('review_by')->nullable()->comment('海聯審閱人員');
            $table->foreign('review_by')->references('username')->on('users');
            $table->string('review_at')->nullable()->comment('海聯審閱的時間點');
        });

        Schema::table('two_year_tech_department_history_data', function (Blueprint $table) {
            $table->enum('info_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('資料狀態（editing|waiting|returned|confirmed');
            $table->enum('quota_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('名額狀態（editing|waiting|returned|confirmed');
            $table->text('review_memo')->nullable()->comment('海聯審閱備註');
            $table->string('review_by')->nullable()->comment('海聯審閱人員');
            $table->foreign('review_by')->references('username')->on('users');
            $table->string('review_at')->nullable()->comment('海聯審閱的時間點');
        });

        Schema::table('graduate_department_history_data', function (Blueprint $table) {
            $table->enum('info_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('資料狀態（editing|waiting|returned|confirmed');
            $table->enum('quota_status', ['editing', 'waiting', 'returned', 'confirmed'])->comment('名額狀態（editing|waiting|returned|confirmed');
            $table->text('review_memo')->nullable()->comment('海聯審閱備註');
            $table->string('review_by')->nullable()->comment('海聯審閱人員');
            $table->foreign('review_by')->references('username')->on('users');
            $table->string('review_at')->nullable()->comment('海聯審閱的時間點');
        });

    }
}
