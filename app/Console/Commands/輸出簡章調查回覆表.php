<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\SchoolData;

use mPDF;

class 輸出簡章調查回覆表 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '產生pdf:簡章調查回覆表
                            {school_code : The ID of the school}
                            {system_id : The ID of the system type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '系統輸出簡章調查回覆表';

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
        $mpdf = new mPDF('','A4',9,'DejaVuSans');

        $mpdf->autoScriptToLang = true;

        $mpdf->autoLangToFont = true;

        $mpdf->SetWatermarkImage(__DIR__ . '/../../../public/img/sunnyworm.png', '0.4');

        $mpdf->showWatermarkImage = true;

        $datas = SchoolData::whereHas('departments')
            ->with(['systems' => function ($query) {
                $query->where('type_id', '=', '1');
            }])->orderby('sort_order', 'ASC')->get();

        $css = 'table, th, td {
                    border: 2px solid black;
                    border-collapse: collapse;
                    overflow: wrap;
                }
                
                th {
                    width: 6%;
                }';

        $result = '';

        foreach ($datas as $data) {
            $mpdf->Bookmark($data->title . ' ' . $data->eng_title);

            $table = '<h3 style="text-align: center">' . $data->title . ' ' . $data->eng_title . '</h3>';

            $table .= '<table style="width: 100%;">';

            $table .= '<tr><th rowspan="3">學校基本資料</th><td>學校代碼</td><td>' . $data->id . '</td><td>承辦單位</td><td>' . $data->organization . '</td></tr>';

            $table .= '<tr><td>聯絡電話</td><td>' . $data->phone . '</td><td>地址</td><td>' . $data->address . '</td></tr>';

            $table .= '<tr><td>傳真</td><td>' . $data->fax . '</td><td>網址</td><td>' . $data->url . '</td></tr>';

            if ($data->has_scholarship) {
                $scholarship = $data->scholarship_url . ' ' . $data->scholarship_dept;
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

            $table .= '<tr><th>備註</th><td colspan="4">' . $data->systems['0']['description'] . '</td></tr>';

            $table .= '</table>';

            $table .= '<br>';

            $table .= '<table style="width: 100%;">';

            $table .= '<tr><th>系所分則</th><th>個人申請繳交資料說明</th></tr>';

            foreach ($data->departments as $dept) {
                $table .= '<tr><td colspan="2" bgcolor="#dcdcdc">' . $dept->card_code . ' ' . $dept->title . ' ' . $dept->eng_title . '</td></tr>';

                $table .= '<tr><td style="width: 50%;">' . $dept->description . '</td><td style="width: 50%;"></td></tr>';
            }

            $table .= '</table>';

            $table .= '<br><br>';

            $result .= $table;
        }

        $mpdf->WriteHTML($css,1);

        $mpdf->WriteHTML($result);

        $mpdf->Output(storage_path('app/public/document.pdf'), 'F');
    }
}
