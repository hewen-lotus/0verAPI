<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupTwoYearTechDepartmentDataAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('two_year_tech_department_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->unsignedInteger('main_group')->change();
            $table->unsignedInteger('sub_group')->change();
            $table->unsignedInteger('evaluation')->change();

            $table->foreign('main_group')->references('id')->on('department_groups');
            $table->foreign('sub_group')->references('id')->on('department_groups');
            $table->foreign('evaluation')->references('id')->on('evaluation_levels');
        });

        Schema::table('two_year_tech_department_saved_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->unsignedInteger('main_group')->change();
            $table->unsignedInteger('sub_group')->change();
            $table->unsignedInteger('evaluation')->change();

            $table->foreign('main_group')->references('id')->on('department_groups');
            $table->foreign('sub_group')->references('id')->on('department_groups');
            $table->foreign('evaluation')->references('id')->on('evaluation_levels');
        });

        Schema::table('two_year_tech_department_committed_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->unsignedInteger('main_group')->change();
            $table->unsignedInteger('sub_group')->change();
            $table->unsignedInteger('evaluation')->change();

            $table->foreign('main_group')->references('id')->on('department_groups');
            $table->foreign('sub_group')->references('id')->on('department_groups');
            $table->foreign('evaluation')->references('id')->on('evaluation_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('two_year_tech_department_data', function(Blueprint $table)
        {
            $table->dropForeign('two_year_tech_department_data_main_group_foreign');
            $table->dropForeign('two_year_tech_department_data_sub_group_foreign');
            $table->dropForeign('two_year_tech_department_data_evaluation_foreign');
        });

        Schema::table('two_year_tech_department_saved_data', function(Blueprint $table)
        {
            $table->dropForeign('two_year_tech_department_saved_data_main_group_foreign');
            $table->dropForeign('two_year_tech_department_saved_data_sub_group_foreign');
            $table->dropForeign('two_year_tech_department_saved_data_evaluation_foreign');
        });

        Schema::table('two_year_tech_department_committed_data', function(Blueprint $table)
        {
            $table->dropForeign('two_year_tech_department_committed_data_main_group_foreign');
            $table->dropForeign('two_year_tech_department_committed_data_sub_group_foreign');
            $table->dropForeign('two_year_tech_department_committed_data_evaluation_foreign');
        });
    }
}
