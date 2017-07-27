<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\SchoolHistoryData;
use App\SystemHistoryData;
use Carbon\Carbon;
use DB;

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
                $school_code = $row[1];
                $bs_10pa = $row[2];
                $master_10pa = $row[5];
                $phd_10pa = $row[8];
                $bs_bugo = $row[11];
                $master_bugo = $row[12];
                $phd_bugo = $row[13];
                $bs_expand = $row[15];
                $master_expand = $row[16];
                $phd_expand = $row[17];

                $bs_update_quota = array(
                    'last_year_admission_amount' => $bs_10pa,
                    'last_year_surplus_admission_quota' => $bs_bugo,
                    'ratify_expanded_quota' => $bs_expand
                );

                $master_update_quota = array(
                    'last_year_admission_amount' => $master_10pa,
                    'last_year_surplus_admission_quota' => $master_bugo,
                    'ratify_expanded_quota' => $master_expand
                );

                $phd_update_quota = array(
                    'last_year_admission_amount' => $phd_10pa,
                    'last_year_surplus_admission_quota' => $phd_bugo,
                    'ratify_expanded_quota' => $phd_expand
                );


                if (SchoolHistoryData::where('id', '=', $school_code)
                    ->whereHas('systems', function ($query) {
                        $query->where('type_id', '=', 1);
                    })
                    ->exists()
                ) {
                    print_r($school_code);
                    print_r($bs_update_quota);
                    DB::statement("update system_history_data set
                    last_year_admission_amount = ?,
                    last_year_surplus_admission_quota = ?,
                    ratify_expanded_quota = ?
                    where school_code = ? and type_id = '1';",
                    [$bs_10pa, $bs_bugo, $bs_expand, $school_code]);
                }

                if (SchoolHistoryData::where('id', '=', $school_code)
                    ->whereHas('systems', function ($query) {
                        $query->where('type_id', '=', 2);
                    })
                    ->exists()
                ) {
                    print_r($school_code);
                    print_r($bs_update_quota);
                }

                if (SchoolHistoryData::where('id', '=', $school_code)
                    ->whereHas('systems', function ($query) {
                        $query->where('type_id', '=', 3);
                    })
                    ->exists()
                ) {
                    print_r($school_code);
                    print_r($master_update_quota);
                }

                if (SchoolHistoryData::where('id', '=', $school_code)
                    ->whereHas('systems', function ($query) {
                        $query->where('type_id', '=', 4);
                    })
                    ->exists()
                ) {
                    print_r($school_code);
                    print_r($phd_update_quota);
                }
            }
        } else {
            $this->error('離開');
            return 0;
        }
    }
}
