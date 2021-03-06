<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEngDataUseOrNotToAllDapartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department_data', function (Blueprint $table) {
            $table->boolean('use_eng_data')->default(true)->comment('本年度是否提供英文資料');
        });

        Schema::table('department_history_data', function (Blueprint $table) {
            $table->boolean('use_eng_data')->default(true)->comment('本年度是否提供英文資料');
        });

        Schema::table('two_year_tech_department_data', function (Blueprint $table) {
            $table->boolean('use_eng_data')->default(true)->comment('本年度是否提供英文資料');
        });

        Schema::table('two_year_tech_department_history_data', function (Blueprint $table) {
            $table->boolean('use_eng_data')->default(true)->comment('本年度是否提供英文資料');
        });

        Schema::table('graduate_department_data', function (Blueprint $table) {
            $table->boolean('use_eng_data')->default(true)->comment('本年度是否提供英文資料');
        });

        Schema::table('graduate_department_history_data', function (Blueprint $table) {
            $table->boolean('use_eng_data')->default(true)->comment('本年度是否提供英文資料');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
