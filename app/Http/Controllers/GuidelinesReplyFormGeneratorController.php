<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Storage;
use Auth;

use App\SchoolHistoryData;

class GuidelinesReplyFormGeneratorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'switch']);

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
    }

    public function gen(Request $request, $school_code, $system_id)
    {
        /*
         * pdf-generator:bachelor-guidelines-reply-form  系統輸出學士班簡章調查回覆表
         * pdf-generator:master-guidelines-reply-form    系統輸出碩士班簡章調查回覆表
         * pdf-generator:phd-guidelines-reply-form       系統輸出博士班簡章調查回覆表
         * pdf-generator:two-year-guidelines-reply-form  系統輸出港二技簡章調查回覆表
         * {school_code : The ID of the school}
         * {email? : mail result to someone}
         * {--preview : output preview version}'
         */

        $user = Auth::user();

        // 接受 me 參數
        if ($user->school_editor != NULL) {
            if ($school_code == 'me') {
                $school_code = $user->school_editor->school_code;
            }
        }
        
        $system_id = $this->systemIdCollection->get($system_id, 0);

        if (SchoolHistoryData::where('id', '=', $school_code)
            ->whereHas('systems', function ($query) use ($system_id) {
                $query->where('type_id', '=', $system_id);
            })
            ->exists() && Auth::user()->school_editor->school_code == $school_code
        ) {
            switch ($system_id) {
                case 1:
                    $command = 'pdf-generator:bachelor-guidelines-reply-form';
                    break;

                case 2:
                    $command = 'pdf-generator:two-year-guidelines-reply-form';
                    break;

                case 3:
                    $command = 'pdf-generator:master-guidelines-reply-form';
                    break;

                case 4:
                    $command = 'pdf-generator:phd-guidelines-reply-form';
                    break;

                default:
                    $messages = ['School or Department not found.'];
                    return response()->json(compact('messages'), 404);
                    break;
            }

            if ($request->input('mode') != 'formal') {
                $preview_mode = true;
            } else {
                $preview_mode = false;
            }

            Artisan::queue($command, [
                'school_code' => $school_code,
                'email' => Auth::user()->email,
                '--preview' => $preview_mode
            ]);

            return response()->json(['status' => 'success']);
        } else {
            $messages = ['School or Department not found.'];

            return response()->json(compact('messages'), 404);
        }
    }
}
