<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Storage;

use App\SchoolData;

use mPDF;
use Dompdf\Dompdf;
use Dompdf\Options;

class PDFGeneratorController extends Controller
{
    public function gen() {
        $exec_time = Artisan::call('pdf:generate');

        return response()->json(['total_exec_time' => $exec_time, 'file_url' => Storage::disk('public')->url('document.pdf')]);
        /*
        define("_MPDF_TEMP_PATH", __DIR__ . '/../../../storage/');

        set_time_limit(600);

        $mpdf = new mPDF('','A4',9,'DejaVuSans');

        $mpdf->autoScriptToLang = true;

        $mpdf->autoLangToFont = true;

        $mpdf->SetWatermarkImage(__DIR__ . '/../../../public/img/sunnyworm.png');

        $mpdf->watermarkImageAlpha = '0.4';

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
            //$mpdf->Bookmark($data->title . ' ' . $data->eng_title);

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

        $mpdf->Output();
        */
    }

    public function dompdf() {
        set_time_limit(600);
        $options = new Options();

        $options->set('defaultFont', 'DejaVuSans');

        $options->set('isFontSubsettingEnabled', 'true');

        //$dompdf = new Dompdf($options);

        /*
        $mpdf = new mPDF('','A4',9,'DejaVuSans');

        $mpdf->autoScriptToLang = true;

        $mpdf->autoLangToFont = true;

        $mpdf->SetWatermarkImage(__DIR__ . '/../../../public/img/sunnyworm.png');

        $mpdf->watermarkImageAlpha = '0.4';

        $mpdf->showWatermarkImage = true;
        */

        $datas = SchoolData::whereHas('departments')
            ->with(['systems' => function ($query) {
                $query->where('type_id', '=', '1');
            }])->orderby('sort_order', 'ASC')->get();

        $result = '<!DOCTYPE html><html><head><meta charset="utf-8"><style>';

        $css = 'body {
                    font-family: DejaVu Sans;
                }
                
                table, th, td {
                    border: 2px solid black;
                    border-collapse: collapse;
                    overflow: wrap;
                }
                
                th {
                    width: 6%;
                }';

        $result .= $css;

        $result .= '</style><title>Title </title></head><body>';

        foreach ($datas as $data) {
            //$mpdf->Bookmark($data->title . ' ' . $data->eng_title);

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

        $result .= '</body></html>';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($result);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
        /*
        $mpdf->WriteHTML($css,1);

        $mpdf->WriteHTML($result);

        $mpdf->Output();
        */
    }
}
