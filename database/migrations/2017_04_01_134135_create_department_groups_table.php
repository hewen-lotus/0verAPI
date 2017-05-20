<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 學群
        Schema::create('department_groups', function (Blueprint $table) {
            $table->increments('id')->comment('學群代碼');
            $table->string('title')->comment('學群名稱');
            $table->string('eng_title')->comment('學群英文名稱');
            $table->string('created_at');
            $table->string('created_by')->nullable();
            $table->foreign('created_by')->references('username')->on('admins');
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
        Schema::table('department_groups', function (Blueprint $table) {
            $table->dropForeign('department_groups_created_by_foreign');
        });

        Schema::dropIfExists('department_groups');
    }
}
