<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAllDescriptionsToLongtext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `system_history_data` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `system_data` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `department_data` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `department_history_data` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `graduate_department_data` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `graduate_department_history_data` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `two_year_tech_department_data` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');

        DB::statement('ALTER TABLE `two_year_tech_department_history_data` MODIFY COLUMN `description` LONGTEXT NOT NULL, MODIFY COLUMN `eng_description` LONGTEXT NOT NULL;');
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
