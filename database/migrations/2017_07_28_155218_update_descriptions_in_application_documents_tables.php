<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDescriptionsInApplicationDocumentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `dept_application_docs` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `dept_history_application_docs` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `graduate_dept_application_docs` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `graduate_dept_history_application_docs` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `two_year_tech_dept_application_docs` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `two_year_tech_dept_history_application_docs` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');
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
