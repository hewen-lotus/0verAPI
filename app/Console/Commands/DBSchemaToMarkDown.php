<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Storage;
use Carbon\Carbon;

class DBSchemaToMarkDown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:generate-markdown';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '將 DB 結構轉成 Markdown 格式';

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
        $now = Carbon::now();

        $tables = DB::select('show tables;');

        $md = '# DB Schema'.PHP_EOL;

        foreach ($tables as $table) {
            foreach ($table as $key => $value) {
                $md .= '## '.$value.PHP_EOL;

                $md .= '|Field|Type|Null|Key|Comment|'.PHP_EOL;

                $md .= '|:--|:--|:--|:--|:--|'.PHP_EOL;

                $infos = DB::select('show full columns from '.$value);

                foreach ($infos as $info) {
                    $md .= '|'.$info->Field.'|'.$info->Type.'|'
                        .$info->Null.'|'.$info->Key.'|'
                        .$info->Comment.'|'.PHP_EOL;
                }

                $md .= PHP_EOL;
            }
        }

        Storage::disk('artisan')->put('DBtoMarkdown/'.$now, $md);

        $this->info('All Done! Your file is at '.storage_path('app/artisan/DBtoMarkdown/'.$now));
    }
}
