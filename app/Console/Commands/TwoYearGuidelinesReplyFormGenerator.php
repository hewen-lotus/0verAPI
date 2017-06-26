<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Swift_SmtpTransport;
use Swift_Mailer;
use Mail;
use App\Mail\GuidelinesReplyFormGenerated;

use App\SchoolData;
use App\EvaluationLevel;

use mPDF;

class TwoYearGuidelinesReplyFormGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf-generator:two-year-guidelines-reply-form
                            {school_code : The ID of the school}
                            {email? : mail result to someone}';

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
        if (SchoolData::where('id', '=', $this->argument('school_code'))
            ->whereHas('systems', function ($query) {
                $query->where('type_id', '=', 2);
            })
            ->exists()
        ) {
            $data = SchoolData::where('id', '=', $this->argument('school_code'))->first();

            $mpdf = new mPDF('UTF-8', 'A4', 9, 'sun-exta');

            $mpdf->autoScriptToLang = true;

            $mpdf->autoLangToFont = true;

            $mpdf->SetWatermarkImage(public_path('img/manysunnyworm.jpg'), '0.2', 'D');

            $mpdf->showWatermarkImage = true;

            $mpdf->shrink_tables_to_fit = 0;

            $css = '
                table, th, td {
                    border: 2px solid black;
                    border-collapse: collapse;
                    overflow: wrap;
                }
            ';

            $mpdf->Bookmark($data->title . ' ' . $data->eng_title);

            $table = '<h3 style="text-align: center">' . $data->title . ' ' . $data->eng_title . ' (學士班)</h3>';

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

            $depts = $data->departments()->get();

            $total_admission_placement_quota = 0; // 聯合分發總人數

            $total_admission_selection_quota = 0; // 個人申請總人數

            $total_self_enrollment_quota = 0; // 自招總人數

            foreach ($depts as $dept) {
                $total_admission_placement_quota += $dept->admission_placement_quota;

                $total_admission_selection_quota += $dept->admission_selection_quota;

                $total_self_enrollment_quota += $dept->self_enrollment_quota;
            }

            $system = $data->systems()->where('type_id', '=', 1)->get();

            $table .= '<tr><th>總計</th><td colspan="4">' . $data->departments()->count() . ' 系組 / (聯合分發：' . $total_admission_placement_quota . ' 人，個人申請：' . $total_admission_selection_quota . ' 人，自招；' . $total_self_enrollment_quota . ' 人)<br />上學年度新生總量 10%：' . (int)$system['0']['last_year_admission_amount'] . ' 人,本國學生學士班未招足名額：' . (int)$system['0']['last_year_surplus_admission_quota'] . ' 人, 教育部核定擴增名額：' . (int)$system['0']['ratify_expanded_quota'] . ' 人</td></tr>';

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

            $table .= '<tr><th>備註</th><td colspan="4">' . $system['0']['description'] . '</td></tr>';

            $table .= '</table>';

            $table .= '<br>';

            $table .= '<table style="width: 100%;">';

            $table .= '<tr><th style="width: 10%;" rowspan="2">系所代碼<br />(志願代碼)</th><th colspan="3">名額</th><th style="width: 50%;" rowspan="2">系所分則</th><th style="width: 50%;" rowspan="2">個人申請繳交資料說明</th></tr>';

            $table .= '<tr><th style="width: 4%;">聯</th><th style="width: 4%;">個</th><th style="width: 4%;">自</th></tr>';

            foreach ($depts as $dept) {
                $table .= '<tr>';

                $table .= '<td rowspan="2" align="center" vertical-align="middle">' . $dept->id . '<br />(' . $dept->card_code . ')</td>';

                $table .= '<td rowspan="2" align="center" vertical-align="middle">' . $dept->admission_placement_quota . '</td>';

                $table .= '<td rowspan="2" align="center" vertical-align="middle">' . $dept->admission_selection_quota . '</td>';

                if ($dept->has_self_enrollment) {
                    $dept_self_enrollment_quota = $dept->self_enrollment_quota;
                } else {
                    $dept_self_enrollment_quota = '-';
                }

                $table .= '<td rowspan="2" align="center" vertical-align="middle">' . $dept_self_enrollment_quota . '</td>';

                if ($dept->has_special_class) {
                    $dept_has_special_class = '是';
                } else {
                    $dept_has_special_class = '否';
                }

                $evaluation_level = EvaluationLevel::find($dept->evaluation);

                // TODO 好像還要加類組？
                $table .= '<td colspan="2">' . $data->title . ' ' . $dept->title . '<br />' . $dept->eng_title . '<br />開設專班：' . $dept_has_special_class . '&nbsp;&nbsp;&nbsp;&nbsp;最近一次系所評鑑：' . $evaluation_level->title . '</td>';

                $table .= '</tr>';

                // TODO 好像還有一格
                $table .= '<tr><td>' . $dept->description . '</td><td>這格是什麼？Orz</td></tr>';
            }

            $table .= '</table>';

            $table .= '<br><br>';

            $mpdf->WriteHTML($css, 1);

            $mpdf->WriteHTML($table, 2);

            if ($this->argument('email')) {
                $mpdf->Output(sys_get_temp_dir() . '/' . $data->title . '-學士班簡章調查回覆表.pdf', 'F');

                $transport = Swift_SmtpTransport::newInstance(
                    \Config::get('mail.host'),
                    \Config::get('mail.port'),
                    \Config::get('mail.encryption'))
                    ->setUsername(\Config::get('mail.username'))
                    ->setPassword(\Config::get('mail.password'))
                    ->setStreamOptions(['ssl' => \Config::get('mail.ssloptions')]);

                $mailer = Swift_Mailer::newInstance($transport);

                Mail::setSwiftMailer($mailer);

                //Mail::to($this->argument('email'))->send(new GuidelinesReplyFormGenerated());

                Mail::send('emails.guidelines-reply-form', [], function ($m) use ($data) {
                    $m->to($this->argument('email'))->subject($data->title . '-學士班簡章調查回覆表');

                    $m->attach(sys_get_temp_dir() . '/' . $data->title . '-學士班簡章調查回覆表.pdf');
                });

                $this->info('信件已寄出！');
            } else {
                $mpdf->Output(storage_path('app/public/' . $data->title . '-學士班簡章調查回覆表.pdf'), 'F');

                $this->info('PDF 產生完成！');
            }

            return response()->json(['status' => 'success']);
        }

        $this->error('school_code 或所屬 system_id 不存在！');

        return response()->json(['status' => 'failed']);
    }
}
