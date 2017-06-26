<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TwoYearGuidelinesReplyFormGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf-generator:two-year-guidelines-reply-form
                            {school_code : The ID of the school}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '系統輸出港二技簡章調查回覆表';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
