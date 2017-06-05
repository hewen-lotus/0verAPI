<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use DB;
use Auth;
use Validator;

use App\SystemQuota;

class SystemQuotaController extends Controller
{
    public function index(Request $request, $school_id)
    {
        $user = Auth::user();

        // 確認是否有登入
        if (!$user) {
            $messages = array('User need to login');
            return response()->json(compact('messages'), 401);
        }

        // 確認使用者權限
        if ($user->can('view', [SystemQuota::class, $school_id])) {
            // 設定 school id（可能是 me）
            $school_id = $user->school_editor->school_code;

            // 取得此校所有學制第一階段名額資訊
            $systems = SystemQuota::select()
                ->where('school_code', '=', $school_id)
                ->with('updater.school_editor')
                ->get();

            if ($systems == NULL) {
                // 沒有資料？404 啦
                $messages = array('System Data Not Found!');
                return response()->json(compact('messages'), 404);
            } else {
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
}
