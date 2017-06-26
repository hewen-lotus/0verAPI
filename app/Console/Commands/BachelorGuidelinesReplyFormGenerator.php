<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\SchoolData;

use mPDF;

class BachelorGuidelinesReplyFormGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf-generator:bachelor-guidelines-reply-form
                            {school_code : The ID of the school} {system_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '系統輸出學士班簡章調查回覆表';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->systemIdCollection = collect([
            'bachelor' => 1,
            1 => 1,
            'two-year' => 2,
            'twoYear' => 2,
            2 => 2,
            'master' => 3,
            3 => 3,
            'phd' => 4,
            4 => 4,
        ]);

        $this->systemIdtoNameCollection = collect([
            1 => '學士班',
            2 => '港二技',
            3 => '碩士班',
            4 => '博士班',
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $system_id = $this->systemIdCollection->get($this->argument('system_id'), 0);

        $type_name = $this->systemIdtoNameCollection->get($system_id);

        if (SchoolData::where('id', '=', $this->argument('school_code'))
            ->whereHas('systems', function ($query) use ($system_id) {
                $query->where('type_id', '=', $system_id);
            })
            ->exists()
        ) {
            $data = SchoolData::where('id', '=', $this->argument('school_code'))->first();

            $mpdf = new mPDF('UTF-8', 'A4', 9, 'sun-exta');

            $mpdf->autoScriptToLang = true;

            $mpdf->autoLangToFont = true;

            $mpdf->SetWatermarkImage(public_path('img/manysunnyworm.jpg'), '0.1', 'D');

            $mpdf->showWatermarkImage = true;

            $css = '
                table, th, td {
                    border: 2px solid black;
                    border-collapse: collapse;
                    overflow: wrap;
                }
            ';

            $mpdf->Bookmark($data->title . ' ' . $data->eng_title);

            $table = '<h3 style="text-align: center">' . $data->title . ' ' . $data->eng_title . ' (' . $type_name . ')</h3>';

            $table .= '<table style="width: 100%;">';

            if ($data->has_self_enrollment) {
                $basic_data_rowspan = 4;
            } else {
                $basic_data_rowspan = 3;
            }

            $table .= '<tr><th rowspan="'. $basic_data_rowspan .'">學校基本資料</th><td>學校代碼</td><td>' . $data->id . '</td><td>承辦單位</td><td>' . $data->organization . '</td></tr>';

            $table .= '<tr><td>聯絡電話</td><td>' . $data->phone . '</td><td>地址</td><td>' . $data->address . '</td></tr>';

            $table .= '<tr><td>傳真</td><td>' . $data->fax . '</td><td>網址</td><td>' . $data->url . '</td></tr>';

            if ($data->has_self_enrollment) {
                $table .= '<tr><td>自招文號</td><td>' . $data->approval_no_of_self_enrollment . '</td><td></td><td></td></tr>';
            }

            if ($data->has_scholarship) {
                $scholarship = '有提供僑生專屬獎學金，請逕洽本校' . $data->scholarship_dept . '<br />僑生專屬獎學金網址：' . $data->scholarship_url;
            } else {
                $scholarship = '未提供';
            }

            $table .= '<tr><th>獎學金</th><td colspan="4">' . $scholarship . '</td></tr>';

            if ($data->has_dorm) {
                $dorm = $data->dorm_info;
            } else {
                $dorm = '無';
            }

            $table .= '<tr><th>宿舍</th><td colspan="4">' . $dorm . ' </td></tr>';

            $system = $data->systems()->where('type_id', '=', $system_id)->get();

            $table .= '<tr><th>備註</th><td colspan="4">' . $system['0']['description'] . '</td></tr>';

            $table .= '</table>';

            $table .= '<br>';

            $table .= '<table style="width: 100%;">';

            $table .= '<tr><th style="width: 10%;" rowspan="2">系所代碼<br />(志願代碼)</th><th colspan="3">名額</th><th style="width: 50%;" rowspan="2">系所分則</th><th style="width: 50%;" rowspan="2">個人申請繳交資料說明</th></tr>';

            $table .= '<tr><th style="width: 4%;">聯</th><th style="width: 4%;">個</th><th style="width: 4%;">自</th></tr>';

            if ($system_id == 1) {
                $depts = $data->departments()->get();
            } else if ($system_id == 2) {
                $depts = $data->two_year_tech_departments()->get();
            } else {
                $depts = $data->graduate_departments()->where('system_id', '=', $system_id)->get();
            }

            //foreach ($depts as $dept) {
            //    $table .= '<tr><td colspan="2" bgcolor="#dcdcdc">' . $dept->card_code . ' ' . $dept->title . ' ' . $dept->eng_title . '</td></tr>';

            //    $table .= '<tr><td style="width: 50%;">' . $dept->description . '</td><td style="width: 50%;"></td></tr>';
            //}

            $table .= '</table>';

            $table .= '<br><br>';

            $mpdf->WriteHTML($css, 1);

            $mpdf->WriteHTML($table, 2);

            $mpdf->Output(storage_path('app/public/document.pdf'), 'F');

            $this->info('PDF 產生完成！');

            return response()->json(['status' => 'success']);
        }

        $this->error('school_code 或所屬 system_id 不存在！');

        return response()->json(['status' => 'failed']);
    }
}
