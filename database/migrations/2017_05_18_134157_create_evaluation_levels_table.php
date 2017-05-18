<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 評鑑等級
        Schema::create('evaluation_levels', function (Blueprint $table) {
            $table->increments('id')->comment('評鑑等級代碼');
            $table->string('title')->comment('評鑑等級名稱');
            $table->string('eng_title')->comment('評鑑等級英文名稱');
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
        Schema::table('evaluation_levels', function (Blueprint $table) {
            $table->dropForeign('evaluation_levels_created_by_foreign');
        });
    }
}
