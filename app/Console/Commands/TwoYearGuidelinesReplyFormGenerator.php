<?php

namespace App\Console\Commands;

use App\Traits\OverseasMailerTrait;
use Illuminate\Console\Command;
use Mail;
use App\Mail\GuidelinesReplyFormGenerated;

use App\SchoolHistoryData;
use App\EvaluationLevel;
use App\DepartmentGroup;
use App\TwoYearTechDepartmentHistoryApplicationDocument;
use App\GuidelinesReplyFormRecord;

use App;
use DB;
use Auth;
use Carbon\Carbon;

class TwoYearGuidelinesReplyFormGenerator extends Command
{
    use OverseasMailerTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf-generator:two-year-guidelines-reply-form
                            {school_code : The ID of the school}
                            {email? : mail result to someone}
                            {--preview : output preview version}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '系統輸出港二技簡章調查回覆表';

    /** @var SchoolHistoryData */
    private $SchoolHistoryDataModel;

    /** @var EvaluationLevel */
    private $EvaluationLevelModel;

    /** @var DepartmentGroup */
    private $DepartmentGroupModel;

    /** @var TwoYearTechDepartmentHistoryApplicationDocument */
    private $TwoYearTechDepartmentHistoryApplicationDocumentModel;

    /** @var GuidelinesReplyFormRecord */
    private $GuidelinesReplyFormRecordModel;

    /**
     * Create a new command instance.
     *
     * @param SchoolHistoryData $SchoolHistoryDataModel
     * @param EvaluationLevel $EvaluationLevelModel
     * @param DepartmentGroup $DepartmentGroupModel
     * @param TwoYearTechDepartmentHistoryApplicationDocument $TwoYearTechDepartmentHistoryApplicationDocumentModel
     * @param GuidelinesReplyFormRecord $GuidelinesReplyFormRecordModel
     * @return void
     */
    public function __construct(SchoolHistoryData $SchoolHistoryDataModel, EvaluationLevel $EvaluationLevelModel, DepartmentGroup $DepartmentGroupModel, TwoYearTechDepartmentHistoryApplicationDocument $TwoYearTechDepartmentHistoryApplicationDocumentModel, GuidelinesReplyFormRecord $GuidelinesReplyFormRecordModel)
    {
        parent::__construct();

        $this->SchoolHistoryDataModel = $SchoolHistoryDataModel;

        $this->EvaluationLevelModel = $EvaluationLevelModel;

        $this->DepartmentGroupModel = $DepartmentGroupModel;

        $this->TwoYearTechDepartmentHistoryApplicationDocumentModel = $TwoYearTechDepartmentHistoryApplicationDocumentModel;

        $this->GuidelinesReplyFormRecordModel = $GuidelinesReplyFormRecordModel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->SchoolHistoryDataModel->where('id', '=', $this->argument('school_code'))
            ->whereHas('systems', function ($query) {
                $query->where('type_id', '=', 2);
            })->exists() ) {
            $data = $this->SchoolHistoryDataModel->where('id', '=', $this->argument('school_code'))->latest()->first();

            $pdf_gen_record = ['system_id' => 2, 'school_history_data' => $data->history_id];

            /* 浮水印不會用 QQ
            if ($this->option('preview')) {
                $mpdf->SetWatermarkText('PREVIEW VERSION');

                $mpdf->showWatermarkText = true;
            } else {
                $mpdf->SetWatermarkImage(public_path('img/0verseas-logo.png'), '0.2', 'D');

                $mpdf->showWatermarkImage = true;
            }
            */

            $pdf = App::make('snappy.pdf.wrapper');

            $pdf->setOptions([
                'title' => '',
                'page-size' => 'A4',
                'margin-bottom' => '20mm',
                'margin-left' => '20mm',
                'margin-right' => '20mm',
                'margin-top' => '20mm',
                'disable-javascript' => true
            ]);

            $css = '
                <style type = "text/css">
                @font-face {
                    font-family: "Noto Sans TC";
                    font-style: normal;
                    font-weight: 400;
                    src: url(' . public_path('fonts/NotoSansCJKtc-Regular.otf') . ') format("opentype");
                }
                
                body {
                    font-family: "Noto Sans TC"; 
                }
                
                table, th, td {
                    font-size: 10px;
                    border: 2px solid black;
                    border-collapse: collapse;
                }
                </style>
            ';

            $table = '<h3 style="text-align: center">' . $data->title . ' ' . $data->eng_title . ' (港二技)</h3>';

            $table .= '<table style="width: 100%;">';

            if ($data->has_self_enrollment) {
                $basic_data_rowspan = 4;
            } else {
                $basic_data_rowspan = 3;
            }

            $table .= '<tr><th style="width: 8%;" rowspan="'. $basic_data_rowspan .'">學校基本資料</th><td style="width: 8%; text-align: right; vertical-align: middle;">學校代碼</td><td>' . $data->id . '</td><td style="width: 8%; text-align: right; vertical-align: middle;">承辦單位</td><td>' . $data->organization . '<br />' . $data->eng_organization . '</td></tr>';

            $table .= '<tr><td style="width: 8%; text-align: right; vertical-align: middle;">聯絡電話</td><td>' . $data->phone . '</td><td style="width: 8%; text-align: right; vertical-align: middle;">地址</td><td>' . $data->address . '<br />' . $data->eng_address . '</td></tr>';

            $table .= '<tr><td style="width: 8%; text-align: right; vertical-align: middle;">傳真</td><td>' . $data->fax . '</td><td style="width: 8%; text-align: right; vertical-align: middle;">網址</td><td>中：' . $data->url . '<br />英：' . $data->eng_url . '</td></tr>';

            if ($data->has_self_enrollment) {
                $table .= '<tr><td style="width: 8%; text-align: right; vertical-align: middle;">自招文號</td><td>' . $data->approval_no_of_self_enrollment . '</td><td></td><td></td></tr>';
            }

            $all_depts = DB::table('two_year_tech_department_history_data as depts')
                ->join(DB::raw('(SELECT id, max(history_id) as newest FROM two_year_tech_department_history_data group by id) deptid'), function($join) {
                    $join->on('depts.id', '=', 'deptid.id');
                    $join->on('depts.history_id', '=', 'newest');
                    $join->where('school_code','=', $this->argument('school_code'));
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

                    // 要顯示在 PDF 的系所清單
                    $depts[] = $dept_QQ;

                    $total_dept++;
                }

                // 所有的系所 history 資料
                $used_dept_history_id[] = ['id' => $dept_QQ->id, 'history_id' => $dept_QQ->history_id];
            }

            $system = $data->systems()->where('type_id', '=', 2)->latest()->first();

            $pdf_gen_record += ['system_history_data' => $system->history_id, 'depts' => $used_dept_history_id];

            $table .= '<tr><th>總計</th><td colspan="4">' . $total_dept . ' 系組 / (個人申請：' . $total_admission_selection_quota . ' 人，自招；' . $total_self_enrollment_quota . ' 人)<br />上學年度新生總量 10%：' . (int)$system->last_year_admission_amount . ' 人,本國學生學士班未招足名額：' . (int)$system->last_year_surplus_admission_quota . ' 人, 教育部核定擴增名額：' . (int)$system->ratify_expanded_quota . ' 人</td></tr>';

            if ($data->has_scholarship) {
                $scholarship = '有提供僑生專屬獎學金，請逕洽本校' . $data->scholarship_dept . '(' . $data->eng_scholarship_dept . ')<br />僑生專屬獎學金網址：<br />中：' . $data->scholarship_url . '<br />英：' . $data->eng_scholarship_url;
            } else {
                $scholarship = '無僑生專屬獎學金';
            }

            $table .= '<tr><th>獎學金</th><td colspan="4">' . $scholarship . '</td></tr>';

            if ($data->has_dorm) {
                $dorm = $data->dorm_info . '<br />' . $data->eng_dorm_info;
            } else {
                $dorm = '無';
            }

            $table .= '<tr><th>宿舍</th><td colspan="4">' . $dorm . ' </td></tr>';

            $table .= '<tr><th>備註</th><td colspan="4">' . $system->description . '<br />' . $system->eng_description . '</td></tr>';

            $table .= '</table>';

            $table .= '<br>';

            foreach ($depts as $dept) {
                if ((bool)$dept->has_self_enrollment) {
                    if ($dept->self_enrollment_quota != NULL) {
                        $dept_self_enrollment_quota = $dept->self_enrollment_quota;
                    } else {
                        $dept_self_enrollment_quota = 0;
                    }
                } else {
                    $dept_self_enrollment_quota = '-';
                }

                $quta_table_block = '<tr>
                                        <th style="width: 33%; text-align: center; vertical-align: middle">系所代碼</th>
                                        <th style="width: 33%; text-align: center; vertical-align: middle">個人申請名額</th>
                                        <th style="width: 33%; text-align: center; vertical-align: middle">自招名額</th>
                                     </tr>
                                     <tr>
                                        <td style="width: 33%; text-align: center; vertical-align: middle">' . $dept->id . '</td>
                                        <td style="width: 33%; text-align: center; vertical-align: middle">' . $dept->admission_selection_quota . '</td>
                                        <td style="width: 33%; text-align: center; vertical-align: middle">' . $dept_self_enrollment_quota . '</td>
                                     </tr>';

                if ((bool)$dept->has_special_class) {
                    $dept_has_special_class = '是 (專班報部文號：'. $dept->approval_no_of_special_class .')';
                } else {
                    $dept_has_special_class = '否';
                }

                if ((bool)$dept->has_RiJian) {
                    $dept_has_RiJian = '有';
                } else {
                    $dept_has_RiJian = '無';
                }

                $evaluation_level = $this->EvaluationLevelModel->find($dept->evaluation);

                if ($dept->sub_group) {
                    $main_group = $this->DepartmentGroupModel->find($dept->main_group);

                    $sub_group = $this->DepartmentGroupModel->find($dept->sub_group);

                    $group = $main_group->title . '、' . $sub_group->title;

                    $eng_group_data = $main_group->eng_title . '. ' . $sub_group->eng_title . '.';
                } else {
                    $main_group = $this->DepartmentGroupModel->find($dept->main_group);

                    $group = $main_group->title;

                    $eng_group_data = $main_group->eng_title . '.';
                }

                $table .= '<table style="width: 100%;">';

                if ($dept->use_eng_data) {
                    $table .= '<tr><td colspan="3">';

                    $table .= '<p style="font-size:12pt; font-weight:bold;">' . $data->title . '&nbsp;' . $dept->title . '</p>' . $group . '<br />開設專班：' . $dept_has_special_class . '<br />日間部二技學制：' . $dept_has_RiJian . '<br />最近一次系所評鑑：' . $evaluation_level->title . ' (' . $evaluation_level->eng_title . ')<br />';

                    $table .= $data->eng_title . '&nbsp;' . $dept->eng_title . '<br />' . $eng_group_data;

                    $table .= '</td></tr>';

                    $table .= $quta_table_block;

                    if ((bool)$dept->has_review_fee) {
                        $doc_output = '◎ ' . $dept->review_fee_detail . '<br />';

                        $eng_doc_output = '◎ ' . $dept->eng_review_fee_detail . '<br />';
                    } else {
                        $doc_output = '';

                        $eng_doc_output = '';
                    }

                    if ($dept->admission_selection_quota > 0) {
                        $docs = $this->TwoYearTechDepartmentHistoryApplicationDocumentModel->where('dept_id', '=', $dept->id)
                            ->where('history_id', '=', $dept->history_id)->with(['paper' => function ($query) use ($dept) {
                                $query->where('dept_id', '=', $dept->id);
                            }])->get();

                        $doc_count = 1;

                        foreach ($docs as $doc) {
                            if ((bool)$doc->required) {
                                $is_required = '(必)';

                                $eng_is_required = '(required)';
                            } else {
                                $is_required = '(選)';

                                $eng_is_required = '(optional)';
                            }

                            if (trim($doc->description) == '' || $doc->description == NULL) {
                                $doc_output .= $doc_count . '. ' . $doc->type->name . $is_required . '<br />';
                            } else {
                                $doc_output .= $doc_count . '. ' . $doc->type->name . $is_required . '：' . $doc->description . '<br />';
                            }

                            if (trim($doc->eng_description) == '' || $doc->eng_description == NULL) {
                                $eng_doc_output .= $doc_count . '. ' . $doc->type->eng_name . $eng_is_required . '<br />';
                            } else {
                                $eng_doc_output .= $doc_count . '. ' . $doc->type->eng_name . $eng_is_required . '：' . $doc->eng_description . '<br />';
                            }

                            if ($doc->paper != NULL) {
                                $doc_output .= '本項目請以紙本方式寄出<br />地址：' . $doc->paper->address . '<br />收件人：' . $doc->paper->recipient . '<br />聯絡電話：' . $doc->paper->phone . '<br />E-mail：' . $doc->paper->email . '<br />收件截止日：' . $doc->paper->deadline . '<br />';

                                $eng_doc_output .= 'Paper letters of recommendation must be sent to the following address: <br />address: ' . $doc->paper->address . '<br />recipient: ' . $doc->paper->recipient . '<br />phone: ' . $doc->paper->phone . '<br />E-mail：' . $doc->paper->email . '<br />deadline: ' . $doc->paper->deadline . '<br />';
                            }

                            $doc_count++;
                        }
                    }

                    $table .= '<tr>
                                   <th colspan="3" style="text-align: center; vertical-align: middle">系所分則</th>
                               </tr>
                               <tr>
                                   <td colspan="3">' . $dept->description . '<br />' . $dept->eng_description . '</td>
                               </tr>
                               <tr>
                                   <th colspan="3" style="text-align: center; vertical-align: middle">個人申請繳交資料說明</th>
                               </tr>
                               <tr>
                                   <td colspan="3">' . $doc_output . '<br />' . $eng_doc_output . '</td>
                               </tr>';
                } else {
                    $table .= '<td colspan="3"><p style="font-size:12pt; font-weight:bold;">' . $data->title . ' ' . $dept->title . '<br />&diams;&diams; 本系今年不提供英文資料 &diams;&diams;</p>' . $group . '<br />' . $dept->eng_title . '<br />開設專班：' . $dept_has_special_class . '<br />日間部二技學制：' . $dept_has_RiJian . '<br />最近一次系所評鑑：' . $evaluation_level->title . '</td>';

                    $table .= '</tr>';

                    if ((bool)$dept->has_review_fee) {
                        $doc_output = '◎ ' . $dept->review_fee_detail . '<br />';
                    } else {
                        $doc_output = '';
                    }

                    if ($dept->admission_selection_quota > 0) {
                        $docs = $this->TwoYearTechDepartmentHistoryApplicationDocumentModel->where('dept_id', '=', $dept->id)
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

                            if ($doc->description == '') {
                                $doc_output .= $doc_count . '. ' . $doc->type->name . $is_required . '<br />';
                            } else {
                                $doc_output .= $doc_count . '. ' . $doc->type->name . $is_required . '：' . $doc->description . '<br />';
                            }

                            if ($doc->paper != NULL) {
                                $doc_output .= '本項目請以紙本方式寄出<br />地址：' . $doc->paper->address . '<br />收件人：' . $doc->paper->recipient . '<br />聯絡電話：' . $doc->paper->phone . '<br />E-mail：' . $doc->paper->email . '<br />收件截止日：' . $doc->paper->deadline . '<br />';
                            }

                            $doc_count++;
                        }
                    }

                    $table .= '<tr>
                                   <th colspan="3" style="text-align: center; vertical-align: middle">系所分則</th>
                               </tr>
                               <tr>
                                   <td colspan="3">' . $dept->description . '</td>
                               </tr>
                               <tr>
                                   <th colspan="3" style="text-align: center; vertical-align: middle">個人申請繳交資料說明</th>
                               </tr>
                               <tr>
                                   <td colspan="3">' . $doc_output . '</td>
                               </tr>';
                }

                $table .= '</table><br />';
            }

            $full_html = '<!DOCTYPE html><html><head>'.$css.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>'.$table.'</body></html>';

            $now = Carbon::now('Asia/Taipei');

            if (Auth::check()) {
                $maker = Auth::user()->name . '  ' . Auth::user()->phone . PHP_EOL . Auth::user()->email;
            } else {
                $maker = 'NCNU Overseas' . PHP_EOL;
            }

            $file_check_code = hash('md5', $table . $maker . $now);

            if (!$this->option('preview')) {
                $pdf->setOptions([
                    'footer-font-size' => '8',
                    'footer-spacing' => '10',
                    'footer-left' => '※承辦人簽章' . PHP_EOL . $maker . PHP_EOL . $now,
                    // 'footer-center' => '※單位主管簽章',
                    'footer-right' => 'page [page] of [topage]' . PHP_EOL . '確認碼：' . $file_check_code
                ]);

                $record = new GuidelinesReplyFormRecord;

                $record->checksum = $file_check_code;

                $record->school_code = $this->argument('school_code');

                $record->system_id = 2;

                $record->data = json_encode($pdf_gen_record);

                $record->created_at = Carbon::now('Asia/Taipei')->toIso8601String();

                $record->save();
            }

            $output_file_name = $data->title . '-港二技簡章調查回覆表-' . $file_check_code . '.pdf';

            if ($this->argument('email')) {
                $pdf->loadHTML($full_html)->save(sys_get_temp_dir() . '/' . $output_file_name);

                // use function in OverseasMailerTrait
                $this->mailer();

                //Mail::to($this->argument('email'))->send(new GuidelinesReplyFormGenerated());

                Mail::send('emails.guidelines-reply-form', [], function ($m) use ($data, $output_file_name) {
                    $m->to($this->argument('email'))->subject($data->title . '-港二技簡章調查回覆表');

                    if (!$this->option('preview')) {
                        $m->bcc('overseas@ncnu.edu.tw');
                    }

                    $m->attach(sys_get_temp_dir() . '/' . $output_file_name);
                });

                $this->info('信件已寄出！');

                unlink(sys_get_temp_dir() . '/' . $output_file_name);
            } else {
                $pdf->loadHTML($full_html)->save(storage_path('app/' . $output_file_name));

                $this->info('PDF 產生完成！');
                //$this->info(json_encode($pdf_gen_record, true));
            }

            return response()->json(['status' => 'success'], 200);
        }

        $this->error('school_code 或所屬 system_id 不存在！');

        return response()->json(['status' => 'failed'], 404);
    }
}
