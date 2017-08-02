<?php
/**
 * Created by PhpStorm.
 * User: zxp86021
 * Date: 2017/8/2
 * Time: 上午 10:45
 */

namespace App\Traits;

use Auth;
use Carbon\Carbon;

use App\User;
use App\SchoolEditor;

trait UpdateLastActionTime
{
    public function school_editor()
    {
        if (User::where('username', '=', Auth::id())->whereHas('school_editor')->exists()) {
            SchoolEditor::where('username', '=', Auth::id())
                ->update([
                    'last_action_at' => Carbon::now()->toIso8601String()
                ]);
        }
    }
}