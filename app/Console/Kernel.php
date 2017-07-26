<?php

namespace App\Console;

use Hamcrest\Core\CombinableMatcher;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DBSchemaToMarkDown::class,
        Commands\CSVToSeeder::class,
        Commands\PersonalAndPriorityDataImport::class,
        Commands\BachelorGuidelinesReplyFormGenerator::class,
        Commands\TwoYearGuidelinesReplyFormGenerator::class,
        Commands\MasterGuidelinesReplyFormGenerator::class,
        Commands\PhDGuidelinesReplyFormGenerator::class,
        Commands\UpdateSchoolTotal::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
