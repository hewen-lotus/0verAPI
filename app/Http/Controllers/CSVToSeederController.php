<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Excel;
use DB;
use Log;

class CSVToSeederController extends Controller
{
    public function import(Request $request) {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(compact('messages'), 400);
        }

        $csv_enctype = mb_detect_encoding(file_get_contents($request->csv_file), 'UTF-8, BIG-5', true);

        $csv_obj = Excel::load($request->csv_file, function($reader) {
            // Getting all results
        }, $csv_enctype)->get();

        $seeds = '';

        $id_to_idcode = array();
        // $array;
        // array_add($array, 'key', $value);

        $i = 1;
        foreach ($csv_obj as $row) {
            $seeds .= '[';
            foreach ($row as $key => $value) {
                if ($key) {
                    if ($value == 'NULL') {
                        $seeds .= '\''.$key.'\' => NULL,';
                    } else if ($value == 'true') {
                        $seeds .= '\''.$key.'\' => true,';
                    } else if ($value == 'false') {
                        $seeds .= '\''.$key.'\' => false,';
                    } else if ($value == 'false') {
                        $seeds .= '\''.$key.'\' => false,';
                    } else {
                        $seeds .= '\''.$key.'\' => \''.addslashes($value).'\',';
                    }
                }
            }
            // saved table
            // $seeds .= '\'modified_by\' => \'admin1\',\'ip_address\' => \'163.22.9.234\',';

            // committed table
            $seeds .= '\'saved_id\' => \''.$i.'\',\'committed_by\' => \'admin1\',\'ip_address\' => \'163.22.9.234\',\'review_status\' => \'editing\',';
            $i++;

            
            $seeds .= '\'created_at\' => Carbon::now()->toIso8601String(),\'updated_at\' => Carbon::now()->toIso8601String()';
            $seeds .= '],'.PHP_EOL;
        }

        return $seeds;
    }
}
