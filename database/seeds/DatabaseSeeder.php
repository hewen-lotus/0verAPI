<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(LocalesTableSeeder::class);
        $this->call(SystemTypesTableSeeder::class);

        if (App::environment('local', 'develop')) {
            $this->call(UsersTableSeeder::class);
            $this->call(AdminsTableSeeder::class);
            $this->call(SchoolDataTableSeeder::class);
            $this->call(SchoolSavedDataTableSeeder::class);
            $this->call(SchoolCommittedDataTableSeeder::class);
            $this->call(SchoolEditorsTableSeeder::class);
            $this->call(SchoolReviewersTableSeeder::class);
            $this->call(SystemDataTableSeeder::class);
            $this->call(ApplicationDocumentTypesTableSeeder::class);
        }
    }
}
