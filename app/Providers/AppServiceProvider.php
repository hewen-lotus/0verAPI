<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Schema;

use App\DepartmentApplicationDocument;
use App\DepartmentHistoryApplicationDocument;
use App\TwoYearTechDepartmentApplicationDocument;
use App\TwoYearTechDepartmentHistoryApplicationDocument;
use App\GraduateDepartmentApplicationDocument;
use App\GraduateDepartmentHistoryApplicationDocument;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // 是否需要減招原因
        Validator::extend('if_decrease_reason_required', function ($attribute, $value, $parameters, $validator) {
            $input = $validator->getData();

            $route = explode('.', $attribute);

            $dept_id = $input[$route[0]][$route[1]][$parameters[0]];

            $admission_placement_quota = $input[$route[0]][$route[1]][$parameters[1]];

            $departmentHistoryData = \App\DepartmentHistoryData::select()
                ->where('id', '=', $dept_id)
                ->latest()
                ->first();

            // 若 admission_placement_quota 比 MIN(last_year_admission_placement_quota, last_year_admission_placement_amount) 小，需要填 decrease_reason_of_admission_placement
            $minimalvalue = min($departmentHistoryData->last_year_admission_placement_quota, $departmentHistoryData->last_year_admission_placement_amount);

            if ($admission_placement_quota >= $minimalvalue) {
                return true;
            } else {
                return !empty($value);
            }
        });

        // 驗證出生時間限制格式（YYYY/MM/DD）
        Validator::extend('birth_limit_date_format', function($attribute, $value, $formats) {
            // iterate through all formats
            foreach($formats as $format) {

                // parse date with current format
                $parsed = date_parse_from_format($format, $value);

                // if value matches given format return true=validation succeeded
                if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0) {
                    return true;
                }
            }

            // value did not match any of the provided formats, so return false=validation failed
            return false;
        });

        // 驗證 array 內有沒有重複的 type
        Validator::extend('unique_array_item', function($attribute, $value, $parameters, $validator) {
            $showed = collect([]);

            foreach ($value as $item) {
                if ( $showed->contains($item['type']) ) {
                    return false;
                } else {
                    $showed->push($item['type']);
                }
            }

            // check type in input array are unique
            return true;
        });

        // 驗證 array 內有沒有帶上不能改的項目
        Validator::extend('not_modifiable_doc_in_array', function($attribute, $value, $parameters, $validator) {
            // required_item_in_array 驗證參數：$system_id, $department_id, $mode
            $system_id = $parameters[0];

            $department_id = $parameters[1];

            if (isset($parameters[2])) { // mode should be 'history' if need to use history db tables
                $mode = $parameters[2];
            } else {
                $mode = NULL;
            }

            if ($mode == 'history') {
                switch ($system_id)
                {
                    case 1:
                        $not_modifiable_docs = DepartmentHistoryApplicationDocument::where('dept_id', '=', $department_id)
                            ->where('modifiable', '=', 0)->get();
                        break;

                    case 2:
                        $not_modifiable_docs = TwoYearTechDepartmentHistoryApplicationDocument::where('dept_id', '=', $department_id)
                            ->where('modifiable', '=', 0)->get();
                        break;

                    case 3:
                        $not_modifiable_docs = GraduateDepartmentHistoryApplicationDocument::where('dept_id', '=', $department_id)
                            ->where('modifiable', '=', 0)->get();
                        break;

                    case 4:
                        $not_modifiable_docs = GraduateDepartmentHistoryApplicationDocument::where('dept_id', '=', $department_id)
                            ->where('modifiable', '=', 0)->get();
                        break;

                    default:
                        return false;
                        break;
                }
            } else {
                switch ($system_id)
                {
                    case 1:
                        $not_modifiable_docs = DepartmentApplicationDocument::where('dept_id', '=', $department_id)
                            ->where('modifiable', '=', 0)->get();
                        break;

                    case 2:
                        $not_modifiable_docs = TwoYearTechDepartmentApplicationDocument::where('dept_id', '=', $department_id)
                            ->where('modifiable', '=', 0)->get();
                        break;

                    case 3:
                        $not_modifiable_docs = GraduateDepartmentApplicationDocument::where('dept_id', '=', $department_id)
                            ->where('modifiable', '=', 0)->get();
                        break;

                    case 4:
                        $not_modifiable_docs = GraduateDepartmentApplicationDocument::where('dept_id', '=', $department_id)
                            ->where('modifiable', '=', 0)->get();
                        break;

                    default:
                        return false;
                        break;
                }
            }

            $pass = true;

            $get_count = 0; // not_modifiable 項目命中次數

            foreach ($not_modifiable_docs as $not_modifiable_doc) {
                foreach ($value as $valueQQ) {
                    if ($not_modifiable_doc->type_id == $valueQQ['type']) {
                        $get_count++;
                    }

                    if ((bool)$not_modifiable_doc->required != (bool)$valueQQ['required']) {
                        $pass = false;
                    }
                }

                if ($get_count == 0) {
                    $pass = false;
                }
                
                $get_count = 0;
            }

            if ($pass) {
                return true;
            } else {
                return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
