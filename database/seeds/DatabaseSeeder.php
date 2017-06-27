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
        $this->call(UsersTableSeeder::class);
        // $this->call(LocalesTableSeeder::class);
        $this->call(SystemTypesTableSeeder::class);
        $this->call(DepartmentGroupsTableSeeder::class);
        $this->call(EvaluationLevelsTableSeeder::class);

        if (App::environment('local', 'develop')) {
            $this->call(AdminsTableSeeder::class);
            $this->call(SchoolDataTableSeeder::class);
            $this->call(SchoolHistoryDataTableSeeder::class);
            $this->call(SystemQuotaRecordsTableSeeder::class);
            $this->call(SchoolEditorsTableSeeder::class);
            $this->call(SchoolReviewersTableSeeder::class);
            $this->call(SystemHistoryDataTableSeeder::class);
            $this->call(GraduateSystemHistoryDataTableSeeder::class);
            $this->call(SystemDataTableSeeder::class);
            $this->call(GraduateSystemDataTableSeeder::class);
            $this->call(ApplicationDocumentTypesTableSeeder::class);
            $this->call(DepartmentDataTableSeeder::class);
            $this->call(DepartmentHistoryDataTableSeeder::class);
            $this->call(GraduateDepartmentDataTableSeeder::class);
            $this->call(GraduateDepartmentHistoryDataTableSeeder::class);
            $this->call(TechDepartmentDataTableSeeder::class);
            $this->call(TechDepartmentHistoryDataTableSeeder::class);
            $this->call(SchoolLastYearSelfEnrollmentAndFiveYearStatusTableSeeder::class);
            $this->call(DeptApplicationDocsSeeder::class);
        }
    }
}
