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

        Validator::extend('if_reason_required', function ($attribute, $value, $parameters, $validator) {
            // 若 admission_placement_quota 比 MIN(last_year_admission_placement_quota, last_year_admission_placement_amount) 小，需要填 decrease_reason_of_admission_placement
            $minimalvalue = min($parameters[1], $parameters[2]);

            if ($parameters[0] > $minimalvalue) {
                return true;
            } else {
                return !empty($value);
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
