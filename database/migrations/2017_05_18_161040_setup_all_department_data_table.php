<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupAllDepartmentDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->comment('審查費用英文細節');
        });

        Schema::table('department_saved_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->comment('審查費用英文細節');
        });

        Schema::table('department_committed_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->comment('審查費用英文細節');
        });

        Schema::table('graduate_department_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->comment('審查費用英文細節');
        });

        Schema::table('graduate_department_saved_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->comment('審查費用英文細節');
        });

        Schema::table('graduate_department_committed_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->comment('審查費用英文細節');
        });

        Schema::table('two_year_tech_department_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->comment('審查費用英文細節');
        });

        Schema::table('two_year_tech_department_saved_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->comment('審查費用英文細節');
        });

        Schema::table('two_year_tech_department_committed_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->boolean('has_review_fee')->comment('是否要收審查費用');
            $table->text('review_fee_detail')->comment('審查費用細節');
            $table->text('eng_review_fee_detail')->comment('審查費用英文細節');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->dropColumn(['has_review_fee', 'review_fee_detail', 'eng_review_fee_detail']);
        });

        Schema::table('department_saved_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->dropColumn(['has_review_fee', 'review_fee_detail', 'eng_review_fee_detail']);
        });

        Schema::table('department_committed_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->dropColumn(['has_review_fee', 'review_fee_detail', 'eng_review_fee_detail']);
        });

        Schema::table('graduate_department_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->dropColumn(['has_review_fee', 'review_fee_detail', 'eng_review_fee_detail']);
        });

        Schema::table('graduate_department_saved_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->dropColumn(['has_review_fee', 'review_fee_detail', 'eng_review_fee_detail']);
        });

        Schema::table('graduate_department_committed_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->dropColumn(['has_review_fee', 'review_fee_detail', 'eng_review_fee_detail']);
        });

        Schema::table('two_year_tech_department_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->dropColumn(['has_review_fee', 'review_fee_detail', 'eng_review_fee_detail']);
        });

        Schema::table('two_year_tech_department_saved_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->dropColumn(['has_review_fee', 'review_fee_detail', 'eng_review_fee_detail']);
        });

        Schema::table('two_year_tech_department_committed_data', function(Blueprint $table)
        {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->dropColumn(['has_review_fee', 'review_fee_detail', 'eng_review_fee_detail']);
        });
    }
}
