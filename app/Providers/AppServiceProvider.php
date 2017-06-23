<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Schema;

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

            if ($admission_placement_quota > $minimalvalue) {
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
