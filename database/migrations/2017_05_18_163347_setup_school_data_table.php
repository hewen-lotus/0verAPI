<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupSchoolDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_data', function (Blueprint $table) {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_dorm')->default(false)->change(); //是否提供宿舍
            $table->boolean('has_scholarship')->default(false)->change(); //是否提供僑生專屬獎學金
            $table->boolean('has_five_year_student_allowed')->default(false)->change(); //[中五]我可以招呢
            $table->boolean('has_self_enrollment')->default(false)->change(); // [自招]是否單獨招收僑生
        });

        Schema::table('school_saved_data', function (Blueprint $table) {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_dorm')->default(false)->change(); //是否提供宿舍
            $table->boolean('has_scholarship')->default(false)->change(); //是否提供僑生專屬獎學金
            $table->boolean('has_five_year_student_allowed')->default(false)->change(); //[中五]我可以招呢
            $table->boolean('has_self_enrollment')->default(false)->change(); // [自招]是否單獨招收僑生
        });

        Schema::table('school_committed_data', function (Blueprint $table) {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_dorm')->default(false)->change(); //是否提供宿舍
            $table->boolean('has_scholarship')->default(false)->change(); //是否提供僑生專屬獎學金
            $table->boolean('has_five_year_student_allowed')->default(false)->change(); //[中五]我可以招呢
            $table->boolean('has_self_enrollment')->default(false)->change(); // [自招]是否單獨招收僑生
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
