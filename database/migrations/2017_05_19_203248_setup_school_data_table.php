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

            $table->renameColumn('approve_no_of_self_enrollment', 'approval_no_of_self_enrollment');

        });

        Schema::table('school_saved_data', function (Blueprint $table) {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->renameColumn('approve_no_of_self_enrollment', 'approval_no_of_self_enrollment');

        });

        Schema::table('school_committed_data', function (Blueprint $table) {
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

            $table->renameColumn('approve_no_of_self_enrollment', 'approval_no_of_self_enrollment');

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
