<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Excel;
use App\AdmissionPlacementStepQuota;

class UpdateAdmissionPlacementStepQuota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update-admission-placement-step-quota {file_path : 檔案路徑}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新大學學制系所各階段名額 (つд ⊂ ) ';

    /** @var AdmissionPlacementStepQuota */
    private $AdmissionPlacementStepQuotaModel;

    /**
     * Create a new command instance.
     *
     * @param AdmissionPlacementStepQuota $AdmissionPlacementStepQuotaModel
     * @return void
     */
    public function __construct(AdmissionPlacementStepQuota $AdmissionPlacementStepQuotaModel)
    {
        parent::__construct();

        $this->AdmissionPlacementStepQuotaModel = $AdmissionPlacementStepQuotaModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // csv 檔需要 id, s1, s2, s3, s4, s5
        //           ^
        //        系所代碼
        if ($this->confirm('此功能將直接修改資料庫資料，是否繼續？')) {
            $path = $this->argument('file_path');

            $input = Excel::load($path, function($reader) {
                // Getting all results
                $reader->calculate(false);
            })->get();

            DB::transaction(function () use ($input) {
                foreach ($input as $data) {
                    $this->AdmissionPlacementStepQuotaModel->updateOrCreate(
                        ['dept_id' => $data['id']],
                        [
                            's1' => $data['s1'],
                            's2' => $data['s2'],
                            's3' => $data['s3'],
                            's4' => $data['s4'],
                            's5' => $data['s5']
                        ]
                    );
                }
            });
        } else {
            $this->error('離開');

            return 1;
        }

        $this->info('做完了 ^^');

        return 0;
    }
}
