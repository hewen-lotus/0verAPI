<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Excel;
use Storage;

class CSVToSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:generate-seeder {csv_file_path : csv 檔案路徑}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '將 CSV 轉成 Database Seeder (*´∀`)~♥';

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
        $accept_mime = collect(['text/csv', 'text/plain']); //可接受的檔案 mime

        $csv_path = $this->argument('csv_file_path');

        $mime = mime_content_type($csv_path);

        if (!$accept_mime->contains($mime)) {
            $this->error('檔案格式不符');
            return 0;
        }

        $output_file_name = last(explode('/', $csv_path)).'.seeder';

        if (Storage::disk('artisan')->exists('seeders/'.$output_file_name)) {
            if ($this->confirm('此檔案產生的 Seeder 已存在，是否覆蓋？')) {
                Storage::disk('artisan')->delete('seeders/'.$output_file_name);
            } else {
                $this->error('Seeder 檔案已存在！');
                return 0;
            }
        }

        $csv_enctype = mb_detect_encoding(file_get_contents($csv_path), 'UTF-8, BIG-5', true);

        $csv_obj = Excel::load($csv_path, function($reader) {
            // Getting all results
        }, $csv_enctype)->get();

        $seeds = '';

        $id_to_idcode = array();
        // $array;
        // array_add($array, 'key', $value);

        $i = 1;
        foreach ($csv_obj as $row) {
            $seeds .= '[';
            foreach ($row as $key => $value) {
                if ($key) {
                    if ($value == 'NULL') {
                        $seeds .= '\''.$key.'\' => NULL,';
                    } else if ($value == 'true') {
                        $seeds .= '\''.$key.'\' => true,';
                    } else if ($value == 'false') {
                        $seeds .= '\''.$key.'\' => false,';
                    } else if ($value == 'false') {
                        $seeds .= '\''.$key.'\' => false,';
                    } else {
                        $seeds .= '\''.$key.'\' => \''.addslashes($value).'\',';
                    }
                }
            }
            // saved table
            // $seeds .= '\'modified_by\' => \'admin1\',\'ip_address\' => \'163.22.9.234\',';

            // committed table
            $seeds .= '\'saved_id\' => \''.$i.'\',\'committed_by\' => \'admin1\',\'ip_address\' => \'163.22.9.234\',\'review_status\' => \'editing\',';
            $i++;


            $seeds .= '\'created_at\' => Carbon::now()->toIso8601String(),\'updated_at\' => Carbon::now()->toIso8601String()';
            $seeds .= '],'.PHP_EOL;
        }

        Storage::disk('artisan')->put('seeders/'.$output_file_name, $seeds);

        $this->info('All Done! Your file is at '.storage_path('app/artisan/seeders/'.$output_file_name));
    }
}
