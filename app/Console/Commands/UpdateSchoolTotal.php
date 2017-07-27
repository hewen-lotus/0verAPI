<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Excel;
use Storage;

class UpdateSchoolTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update-school-total {file_path : 檔案路徑}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新學校名額總量（測試 QQ）';

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
        if ($this->confirm('此功能將直接修改資料庫資料，是否繼續？')) {
            $path = $this->argument('file_path');

            // $csv_enctype = mb_detect_encoding(file_get_contents($path), 'UTF-8, BIG-5', true);

            $obj = Excel::selectSheetsByIndex(2)->load($path, function($reader) {
                // Getting all results
                $reader->calculate(false);
                $reader->noHeading();
                //$reader->dump();
            })->get();

            // print_r($obj[2][2]);
            foreach ($obj as $row) {
                print_r([$row[1], $row[2], $row[5], $row[8], $row[11], $row[12], $row[13], $row[15], $row[16], $row[17]]);
            }
        } else {
            $this->error('離開');
            return 0;
        }
    }
}
