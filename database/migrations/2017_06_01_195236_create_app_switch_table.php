<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppSwitchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('function_open_time', function (Blueprint $table) {
            $table->string('system')->comment('系統名稱');
            $table->string('function')->comment('系統對應的 function name');
            $table->string('start_at')->comment('function 開放時間');
            $table->string('end_at')->comment('function 關閉時間');
            $table->primary(['system', 'function'], 'key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('function_open_time');
    }
}
