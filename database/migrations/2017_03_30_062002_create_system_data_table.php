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
        Schema::create('system_data', function (Blueprint $table) {
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('system')->comment('學制種類（學士, 碩士, 二技, 博士）');
            $table->foreign('system')->references('type')->on('system_types');
            $table->string('description')->comment('學制描述');
            $table->string('eng_description')->comment('學制描述');
            $table->unsignedInteger('quantity_of_overseas')->nullable()->comment('僑生可招收數量');
            $table->unsignedInteger('surplus')->nullable()->comment('上學年本地生未招足名額（二技參照學士）');
            $table->unsignedInteger('expanded')->nullable()->comment('本學年教育部核定擴增名額（二技參照學士）');
            $table->unsignedInteger('distribution')->nullable()->comment('聯合分發名額（聯招；研究所沒有）');
            $table->unsignedInteger('personal_apply')->nullable()->comment('個人申請名額（聯招）');
            $table->unsignedInteger('recruit_by_school')->nullable()->comment('自招名額');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
            $table->primary(['school_code', 'system']);
        });

        Schema::create('system_saved_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('system')->comment('學制種類（學士, 碩士, 二技, 博士）');
            $table->foreign('system')->references('type')->on('system_types');
            $table->string('description')->comment('學制描述');
            $table->string('eng_description')->comment('學制描述');
            $table->unsignedInteger('quantity_of_overseas')->nullable()->comment('僑生可招收數量');
            $table->unsignedInteger('surplus')->nullable()->comment('上學年本地生未招足名額（二技參照學士）');
            $table->unsignedInteger('expanded')->nullable()->comment('本學年教育部核定擴增名額（二技參照學士）');
            $table->unsignedInteger('distribution')->nullable()->comment('聯合分發名額（聯招；研究所沒有）');
            $table->unsignedInteger('personal_apply')->nullable()->comment('個人申請名額（聯招）');
            $table->unsignedInteger('recruit_by_school')->nullable()->comment('自招名額');
            $table->string('modified_by')->nullable()->comment('儲存資料的人是誰');
            $table->foreign('modified_by')->references('username')->on('users');
            $table->string('quantity_modified_by')->nullable()->comment('儲存名額的人是誰');
            $table->foreign('quantity_modified_by')->references('username')->on('users');
            $table->string('ip_address')->comment('按下儲存的人的IP');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('deleted_at')->nullable();
        });

        Schema::create('system_committed_data', function (Blueprint $table) {
            $table->increments('history_id');
            $table->unsignedInteger('saved_id')->comment('對應 saved 表的 id');
            $table->foreign('saved_id')->references('history_id')->on('system_saved_data');
            $table->string('school_code')->comment('學校代碼');
            $table->foreign('school_code')->references('id')->on('school_data');
            $table->string('system')->comment('學制種類（學士, 碩士, 二技, 博士）');
            $table->foreign('system')->references('type')->on('system_types');
            $table->string('description')->comment('學制描述');
            $table->string('eng_description')->comment('學制描述');
            $table->unsignedInteger('quantity_of_overseas')->nullable()->comment('僑生可招收數量');
            $table->unsignedInteger('surplus')->nullable()->comment('上學年本地生未招足名額（二技參照學士）');
            $table->unsignedInteger('expanded')->nullable()->comment('本學年教育部核定擴增名額（二技參照學士）');
            $table->unsignedInteger('distribution')->nullable()->comment('聯合分發名額（聯招；研究所沒有）');
            $table->unsignedInteger('personal_apply')->nullable()->comment('個人申請名額（聯招）');
            $table->unsignedInteger('recruit_by_school')->nullable()->comment('自招名額');
            $table->string('committed_by')->nullable()->comment('送出資料的人是誰');
            $table->foreign('committed_by')->references('username')->on('users');
            $table->string('quantity_committed_by')->nullable()->comment('送出名額的人是誰');
            $table->foreign('quantity_committed_by')->references('username')->on('users');
            $table->string('ip_address')->comment('按下送出的人的IP');
            $table->string('quantity_status')->comment('waiting|confirmed(by 教育部)|editing');
            $table->string('review_status')->comment('waiting|confirmed(by 海聯)|editing');
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
        Schema::table('system_data', function (Blueprint $table) {
            $table->dropForeign('system_data_school_code_foreign');
            $table->dropForeign('system_data_system_foreign');
        });

        Schema::table('system_saved_data', function (Blueprint $table) {
            $table->dropForeign('system_saved_data_school_code_foreign');
            $table->dropForeign('system_saved_data_system_foreign');
            $table->dropForeign('system_saved_data_modified_by_foreign');
            $table->dropForeign('system_saved_data_quantity_modified_by_foreign');
        });

        Schema::table('system_committed_data', function (Blueprint $table) {
            $table->dropForeign('system_committed_data_saved_id_foreign');
            $table->dropForeign('system_committed_data_school_code_foreign');
            $table->dropForeign('system_committed_data_system_foreign');
            $table->dropForeign('system_committed_data_committed_by_foreign');
            $table->dropForeign('system_committed_data_quantity_committed_by_foreign');
            $table->dropForeign('system_committed_data_replied_by_foreign');
            $table->dropForeign('system_committed_data_confirmed_by_foreign');
        });

		Schema::dropIfExists('system_saved_data');
		Schema::dropIfExists('system_committed_data');
        Schema::dropIfExists('system_data');
    }
}
