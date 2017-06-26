<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Storage;

use App\SchoolData;

class GuidelinesReplyFormGeneratorController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth', 'switch']);

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
        $system_id = $this->systemIdCollection->get($system_id, 0);

        if (SchoolData::where('id', '=', $school_code)
            ->whereHas('systems', function ($query) use ($system_id) {
                $query->where('type_id', '=', $system_id);
            })
            ->exists()
        ) {
            //Artisan::queue('產生pdf:簡章調查回覆表', ['school_code' => $school_code, 'system_id' => $system_id]);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'failed']);
    }
}
