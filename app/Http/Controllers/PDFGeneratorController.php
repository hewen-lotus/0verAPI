<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Storage;

class PDFGeneratorController extends Controller
{
    public function gen()
    {
        $exec_time = Artisan::queue('產生pdf:中文');

        return response()->json(['total_exec_time' => $exec_time, 'file_url' => Storage::disk('public')->url('document.pdf')]);
    }
}
