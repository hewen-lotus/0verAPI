<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupCodeToDepartmentData extends Migration
{
    /**
     * 增加類組（1|2|3）欄位到各系所資料表中
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department_data', function (Blueprint $table) {
            $table->enum('group_code', [1, 2, 3])->comment('系所類組（1|2|3）');
        });

        Schema::table('department_history_data', function (Blueprint $table) {
            $table->enum('group_code', [1, 2, 3])->comment('系所類組（1|2|3）');
        });

        Schema::table('two_year_tech_department_data', function (Blueprint $table) {
            $table->enum('group_code', [1, 2, 3])->comment('系所類組（1|2|3）');
        });

        Schema::table('two_year_tech_department_history_data', function (Blueprint $table) {
            $table->enum('group_code', [1, 2, 3])->comment('系所類組（1|2|3）');
        });

        Schema::table('graduate_department_data', function (Blueprint $table) {
            $table->enum('group_code', [1, 2, 3])->comment('系所類組（1|2|3）');
        });

        Schema::table('graduate_department_history_data', function (Blueprint $table) {
            $table->enum('group_code', [1, 2, 3])->comment('系所類組（1|2|3）');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('department_data', function (Blueprint $table) {
            $table->dropColumn('group_code');
        });

        Schema::table('department_history_data', function (Blueprint $table) {
            $table->dropColumn('group_code');
        });

        Schema::table('two_year_tech_department_data', function (Blueprint $table) {
            $table->dropColumn('group_code');
        });

        Schema::table('two_year_tech_department_history_data', function (Blueprint $table) {
            $table->dropColumn('group_code');
        });

        Schema::table('graduate_department_data', function (Blueprint $table) {
            $table->dropColumn('group_code');
        });

        Schema::table('graduate_department_history_data', function (Blueprint $table) {
            $table->dropColumn('group_code');
        });
    }
}
