<?php

namespace App\Console\Commands;

use App\Traits\OverseasMailerTrait;
use Illuminate\Console\Command;
use Mail;
use App\Mail\GuidelinesReplyFormGenerated;

use App\SchoolHistoryData;
use App\EvaluationLevel;
use App\DepartmentGroup;
use App\GraduateDepartmentHistoryApplicationDocument;
use App\GuidelinesReplyFormRecord;

use DB;
use mPDF;
use Auth;
use Carbon\Carbon;

class PhDGuidelinesReplyFormGenerator extends Command
{
    use OverseasMailerTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf-generator:phd-guidelines-reply-form
                            {school_code : The ID of the school}
                            {email? : mail result to someone}
                            {--preview : output preview version}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '系統輸出博士班簡章調查回覆表';

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
        if (SchoolHistoryData::where('id', '=', $this->argument('school_code'))
            ->whereHas('systems', function ($query) {
                $query->where('type_id', '=', 4);
            })->exists() ) {
            $data = SchoolHistoryData::where('id', '=', $this->argument('school_code'))->latest()->first();

            $pdf_gen_record = ['system_id' => 4, 'school_history_data' => $data->history_id];

            $mpdf = new mPDF('UTF-8', 'A4', '10', 'sun-exta');

            $mpdf->SetAuthor('海外聯合招生委員會');

            $mpdf->autoScriptToLang = true;

            $mpdf->autoLangToFont = true;

            if ($this->option('preview')) {
                $mpdf->SetWatermarkText('PREVIEW VERSION');

                $mpdf->showWatermarkText = true;
            } else {
                $mpdf->SetWatermarkImage(public_path('img/0verseas-logo.png'), '0.2', 'D');

                $mpdf->showWatermarkImage = true;
            }

            $mpdf->shrink_tables_to_fit = 0;

            $css = '
                table, th, td {
                    border: 2px solid black;
                    border-collapse: collapse;
                    overflow: wrap;
                }
            ';

            $mpdf->Bookmark($data->title . ' ' . $data->eng_title);

            $table = '<h3 style="text-align: center">' . $data->title . ' ' . $data->eng_title . ' (博士班)</h3>';

            $table .= '<table style="width: 100%;">';

            if ($data->has_self_enrollment) {
                $basic_data_rowspan = 4;
            } else {
                $basic_data_rowspan = 3;
            }

            $table .= '<tr><th rowspan="'. $basic_data_rowspan .'">學校基本資料</th><td style="width: 10%; text-align: right; vertical-align: middle;">學校代碼</td><td>' . $data->id . '</td><td style="width: 10%; text-align: right; vertical-align: middle;">承辦單位</td><td>' . $data->organization . '</td></tr>';

            $table .= '<tr><td style="width: 10%; text-align: right; vertical-align: middle;">聯絡電話</td><td>' . $data->phone . '</td><td style="width: 10%; text-align: right; vertical-align: middle;">地址</td><td>' . $data->address . '</td></tr>';

            $table .= '<tr><td style="width: 10%; text-align: right; vertical-align: middle;">傳真</td><td>' . $data->fax . '</td><td style="width: 10%; text-align: right; vertical-align: middle;">網址</td><td>' . $data->url . '</td></tr>';

            if ($data->has_self_enrollment) {
                $table .= '<tr><td style="width: 10%; text-align: right; vertical-align: middle;">自招文號</td><td>' . $data->approval_no_of_self_enrollment . '</td><td></td><td></td></tr>';
            }

            $all_depts = DB::table('graduate_department_history_data as depts')
                ->join(DB::raw('(SELECT id, max(history_id) as newest FROM graduate_department_history_data group by id) deptid'), function($join) {
                    $join->on('depts.id', '=', 'deptid.id');
                    $join->on('depts.history_id', '=', 'newest');
                    $join->where('school_code','=', $this->argument('school_code'));
                    $join->where('system_id','=', 4);
                })->select('depts.*')->orderBy('sort_order', 'ASC')->get();

            $total_admission_selection_quota = 0; // 個人申請總人數

            $total_self_enrollment_quota = 0; // 自招總人數

            $total_dept = 0; // 系所總數

            $depts = [];

            $used_dept_history_id = [];

            foreach ($all_depts as $dept_QQ) {
                if (($data->has_self_enrollment && $dept_QQ->has_self_enrollment) || $dept_QQ->admission_selection_quota > 0 || $dept_QQ->self_enrollment_quota > 0) {
                    $total_admission_selection_quota += $dept_QQ->admission_selection_quota;

                    $total_self_enrollment_quota += $dept_QQ->self_enrollment_quota;

                    $depts[] = $dept_QQ;

                    $total_dept++;

                    $used_dept_history_id[] = ['id' => $dept_QQ->id, 'history_id' => $dept_QQ->history_id];
                }
            }

            $system = $data->systems()->where('type_id', '=', 4)->latest()->first();

            $pdf_gen_record += ['system_history_data' => $system->history_id, 'depts' => $used_dept_history_id];

            $table .= '<tr><th>總計</th><td colspan="4">' . $total_dept . ' 系組 / (個人申請：' . $total_admission_selection_quota . ' 人，自招；' . $total_self_enrollment_quota . ' 人)<br />上學年度新生總量 10%：' . (int)$system->last_year_admission_amount . ' 人,本國學生碩士班未招足名額：' . (int)$system->last_year_surplus_admission_quota . ' 人, 教育部核定擴增名額：' . (int)$system->ratify_expanded_quota . ' 人</td></tr>';

            if ($data->has_scholarship) {
                $scholarship = '有提供僑生專屬獎學金，請逕洽本校' . $data->scholarship_dept . '<br />僑生專屬獎學金網址：' . $data->scholarship_url;
            } else {
                $scholarship = '無僑生專屬獎學金';
            }

            $table .= '<tr><th>獎學金</th><td colspan="4">' . $scholarship . '</td></tr>';

            if ($data->has_dorm) {
                $dorm = $data->dorm_info;
            } else {
                $dorm = '無';
            }

            $table .= '<tr><th>宿舍</th><td colspan="4">' . $dorm . ' </td></tr>';

            $table .= '<tr><th>備註</th><td colspan="4">' . $system->description . '</td></tr>';

            $table .= '</table>';

            $table .= '<br>';

            $table .= '<table style="width: 100%;">';

            $table .= '<tr><th style="width: 11%;" rowspan="2">系所代碼</th><th style="width: 5%;" colspan="2">名額</th><th style="width: 44%;" rowspan="2">系所分則</th><th style="width: 44%;" rowspan="2">個人申請繳交資料說明</th></tr>';

            $table .= '<tr><th style="width: 4%;">個</th><th style="width: 4%;">自</th></tr>';

            $table .= '</table>';

            foreach ($depts as $dept) {
                $table .= '<table style="width: 100%;"><tr>';

                $table .= '<td rowspan="2" style="width: 11%; text-align: center; vertical-align: middle">' . $dept->id . '</td>';

                $table .= '<td rowspan="2" style="width: 4%; text-align: center; vertical-align: middle">' . $dept->admission_selection_quota . '</td>';

                if ((bool)$dept->has_self_enrollment) {
                    if ($dept->self_enrollment_quota != NULL) {
                        $dept_self_enrollment_quota = $dept->self_enrollment_quota;
                    } else {
                        $dept_self_enrollment_quota = 0;
                    }
                } else {
                    $dept_self_enrollment_quota = '-';
                }

                $table .= '<td rowspan="2" style="width: 4%; text-align: center; vertical-align: middle">' . $dept_self_enrollment_quota . '</td>';

                if ((bool)$dept->has_special_class) {
                    $dept_has_special_class = '是';
                } else {
                    $dept_has_special_class = '否';
                }

                $evaluation_level = EvaluationLevel::find($dept->evaluation);

                $main_group = DepartmentGroup::find($dept->main_group);

                $sub_group = DepartmentGroup::find($dept->sub_group);

                if ($sub_group) {
                    $group = $main_group->title . '、' . $sub_group->title;
                } else {
                    $group = $main_group->title;
                }

                $table .= '<td colspan="2">' . $data->title . ' ' . $dept->title . '（' . $group . '）<br />' . $dept->eng_title . '<br />開設專班：' . $dept_has_special_class . '&nbsp;&nbsp;&nbsp;&nbsp;最近一次系所評鑑：' . $evaluation_level->title . '</td>';

                $table .= '</tr>';

                if ((bool)$dept->has_review_fee) {
                    $doc_output = '◎ ' . $dept->review_fee_detail . '<br />';
                } else {
                    $doc_output = '';
                }

                if ($dept->admission_selection_quota > 0) {
                    $docs = GraduateDepartmentHistoryApplicationDocument::where('dept_id', '=', $dept->id)
                        ->where('history_id', '=', $dept->history_id)->with(['paper' => function ($query) use ($dept) {
                            $query->where('dept_id', '=', $dept->id);
                        }])->get();

                    $doc_count = 1;

                    foreach ($docs as $doc) {
                        if ((bool)$doc->required) {
                            $is_required = '(必)';
                        } else {
                            $is_required = '(選)';
                        }

                        $doc_output .= $doc_count . '. ' . $doc->type->name . $is_required . '：' . $doc->description . '<br />';

                        if ($doc->paper != NULL) {
                            $doc_output .= '本項目請以紙本方式寄出<br />地址：' . $doc->paper->address . '<br />收件人：' . $doc->paper->recipient . '<br />聯絡電話：' . $doc->paper->phone . '<br />E-mail：' . $doc->paper->email . '<br />收件截止日：' . $doc->paper->deadline . '<br />';
                        }

                        $doc_count++;
                    }
                }

                $table .= '<tr><td style="width: 44%;">' . $dept->description . '</td><td style="width: 44%;">' . $doc_output . '</td></tr></table>';
            }

            $now = Carbon::now('Asia/Taipei');

            if (Auth::check()) {
                $maker = Auth::user()->name . '&nbsp;&nbsp;' . Auth::user()->phone . '<br />' . Auth::user()->email . '<br />';
            } else {
                $maker = 'NCNU Overseas<br />';
            }

            $file_check_code = hash('md5', $table . $maker . $now);

            if (!$this->option('preview')) {
                $mpdf->SetHTMLFooter('
                    <table  style="width: 100%; vertical-align: top; border: none; font-size: 8pt;"><tr style="border: none;">
                    <td style="width: 33%; border: none;">※承辦人簽章<br />' . $maker . $now . '</td>
                    <td style="width: 33%; border: none;">※單位主管簽章</td>
                    <td style="width: 33%; text-align: center; vertical-align: bottom; border: none;"><span>page {PAGENO} of {nbpg}<br />確認碼：' . $file_check_code . '</span></td>
                    </tr></table>
                ');

                $record = new GuidelinesReplyFormRecord;

                $record->checksum = $file_check_code;

                $record->school_code = $this->argument('school_code');

                $record->system_id = 4;

                $record->data = json_encode($pdf_gen_record);

                $record->created_at = Carbon::now('Asia/Taipei')->toIso8601String();

                $record->save();
            }

            $output_file_name = $data->title . '-博士班簡章調查回覆表-' . $file_check_code . '.pdf';

            $mpdf->WriteHTML($css, 1);

            $mpdf->WriteHTML($table, 2);

            if ($this->argument('email')) {
                $mpdf->Output(sys_get_temp_dir() . '/' . $output_file_name, 'F');

                // use function in OverseasMailerTrait
                $this->mailer();

                //Mail::to($this->argument('email'))->send(new GuidelinesReplyFormGenerated());

                Mail::send('emails.guidelines-reply-form', [], function ($m) use ($data, $output_file_name) {
                    $m->to($this->argument('email'))->subject($data->title . '-博士班簡章調查回覆表');

                    if (!$this->option('preview')) {
                        $m->bcc('overseas@ncnu.edu.tw');
                    }

                    $m->attach(sys_get_temp_dir() . '/' . $output_file_name);
                });

                $this->info('信件已寄出！');

                unlink(sys_get_temp_dir() . '/' . $output_file_name);
            } else {
                $mpdf->Output(storage_path('app/' . $output_file_name), 'F');

                $this->info('PDF 產生完成！');
                //$this->info(json_encode($pdf_gen_record, true));
            }

            return response()->json(['status' => 'success'], 200);
        }

        $this->error('school_code 或所屬 system_id 不存在！');

        return response()->json(['status' => 'failed'], 404);
    }
}
