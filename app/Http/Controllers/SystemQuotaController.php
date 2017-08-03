<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use DB;
use Auth;
use Validator;
use Storage;
use Carbon\Carbon;
use Log;

use App\SystemQuota;
use App\SystemQuotaRecord;

class SystemQuotaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'switch']);

        if (Carbon::now()->month <= 9) {
            $this->academic_year = (Carbon::now()->year) - 1;
        } else {
            $this->academic_year = (Carbon::now()->year) - 0;
        }
    }

    public function index(Request $request, $school_id)
    {
        $user = Auth::user();

        // 確認使用者權限
        if ($user->can('view', [SystemQuota::class, $school_id])) {
            // 設定 school id（可能是 me）
            $school_id = $user->school_editor->school_code;

            if (!SystemQuota::where('school_code', '=', $school_id)->exists()) {
                // 沒有資料？404 啦
                $messages = array('System Data Not Found!');
                return response()->json(compact('messages'), 404);
            } else {
                // 取得此校所有學制第一階段名額資訊
                $systems = SystemQuota::select()
                    ->where('school_code', '=', $school_id)
                    ->with('updater.school_editor')
                    ->get();

                // 整理資料，依學制分物件
                $result = [];

                // 二技學制參照學士
                foreach ($systems as $system) {
                    if ($system->type_id == 1) {
                        $result += ['bachelor' => $system];
                    } else if ($system->type_id == 3) {
                        $result += ['master' => $system];
                    } else {
                        $result += ['phd' => $system];
                    }
                }
            }

            // TODO 擴增名額調查表掃描檔、擴增名額調查表試算表檔、證明文件

            // 回傳結果
            return $result;
        } else {
            $messages = array('User don\'t have permission to access');
            return response()->json(compact('messages'), 403);
        }
    }

    public function update(Request $request, $school_id)
    {
        $user = Auth::user();

        $academic_year_we_need = [$this->academic_year - 1, $this->academic_year - 2, $this->academic_year - 3];

        // 學士及二技 前三年海外聯合招生管道總分發名額數之平均
        $BachelorLastThreeYearsAvg = DB::table('system_quota_records')
            ->select(DB::raw('(admission_selection_amount + admission_placement_amount) as totalamount'))
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', 1)
            ->whereIn('academic_year', $academic_year_we_need)
            ->avg('totalamount');

        // 碩士 前三年海外聯合招生管道總分發名額數之平均
        $MasterLastThreeYearsAvg = DB::table('system_quota_records')
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', 3)
            ->whereIn('academic_year', $academic_year_we_need)
            ->avg('admission_selection_amount');

        // 博士 前三年海外聯合招生管道總分發名額數之平均
        $PhDLastThreeYearsAvg = DB::table('system_quota_records')
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', 4)
            ->whereIn('academic_year', $academic_year_we_need)
            ->avg('admission_selection_amount');

        $Bachelor10pa = DB::table('system_quota')
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', 1)
            ->pluck('last_year_admission_amount');

        $Master10pa = DB::table('system_quota')
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', 3)
            ->pluck('last_year_admission_amount');

        $PhD10pa = DB::table('system_quota')
            ->where('school_code', '=', $school_id)
            ->where('type_id', '=', 4)
            ->pluck('last_year_admission_amount');

        $validator = Validator::make($request->all(), [
            'Bachelor_last_year_surplus_admission_quota' => 'required|integer|min:0', //本地生招生缺額數
            'Bachelor_expanded_quota' => 'required|integer|min:0', //欲申請擴增名額
            'Bachelor_self_enrollment_quota' => 'required|integer|min:0', //單獨招收名額
            'Bachelor_admission_quota' => 'required|integer|min:0', //海外聯合招生管道名額
            'Master_last_year_surplus_admission_quota' => 'required|integer|min:0', //本地生招生缺額數
            'Master_expanded_quota' => 'required|integer|min:0', //欲申請擴增名額
            'Master_self_enrollment_quota' => 'required|integer|min:0', //單獨招收名額
            'Master_admission_quota' => 'required|integer|min:0', //海外聯合招生管道名額
            'PhD_last_year_surplus_admission_quota' => 'required|integer|min:0', //本地生招生缺額數
            'PhD_expanded_quota' => 'required|integer|min:0', //欲申請擴增名額
            'PhD_self_enrollment_quota' => 'required|integer|min:0', //單獨招收名額
            'PhD_admission_quota' => 'required|integer|min:0', //海外聯合招生管道名額
            'survey_file_with_seal' => 'required|file', //核章過後之申請僑生及港澳生專案擴增名額調查表
            'survey_file' => 'required|file', //申請僑生及港澳生專案擴增名額調查表
            'files' => 'required|array', //最近四學年度各僑生招生管道之提供名額、錄取人數及註冊人數等相關資料
            'files.*' => 'file',
        ]);

        if($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(compact('messages'), 400);
        }

        if ($Bachelor10pa + $request->Bachelor_last_year_surplus_admission_quota + $request->Bachelor_expanded_quota < $BachelorLastThreeYearsAvg + $request->Bachelor_admission_quota + $request->Bachelor_self_enrollment_quota) {
            $messages = array('學士名額不符規則');
            return response()->json(compact('messages'), 400);
        }

        if ($Master10pa + $request->Master_last_year_surplus_admission_quota + $request->Master_expanded_quota < $MasterLastThreeYearsAvg + $request->Master_admission_quota + $request->Master_self_enrollment_quota) {
            $messages = array('碩士名額不符規則');
            return response()->json(compact('messages'), 400);
        }

        if ($PhD10pa + $request->PhD_last_year_surplus_admission_quota + $request->PhD_expanded_quota < $PhDLastThreeYearsAvg + $request->PhD_admission_quota + $request->PhD_self_enrollment_quota) {
            $messages = array('博士名額不符規則');
            return response()->json(compact('messages'), 400);
        }

        //$files = $request->files;

        //Log::info(print_r($request->Text,true));
        //Log::info(print_r($files,true));

        //foreach ($files as $file) {
        //    Log::info(gettype($file));
        //    $filename = $file->getClientOriginalName();
        //    $file->move(storage_path('app'), $filename);
            //Storage::putFile('/', $file, 'local');
        //}
        // TODO 新增（更新？）資料

        return 'done';
    }
}
