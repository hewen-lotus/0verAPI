<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateApproveNoOfSpecialClassColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('two_year_tech_department_history_data', function (Blueprint $table) {
            $table->renameColumn('approve_no_of_special_class', 'approval_no_of_special_class');
        });

        Schema::table('two_year_tech_department_data', function (Blueprint $table) {
            $table->renameColumn('approve_no_of_special_class', 'approval_no_of_special_class');
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
