<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\User;
use App\Policies\UserPolicy;
use App\SchoolHistoryData;
use App\Policies\SchoolHistoryDataPolicy;
use App\SystemHistoryData;
use App\Policies\SystemHistoryDataPolicy;
//use App\SystemQuota;
//use App\Policies\SystemQuotaPolicy;
use App\DepartmentHistoryData;
use App\Policies\DepartmentHistoryDataPolicy;
use App\TwoYearTechHistoryDepartmentData;
use App\Policies\TwoYearTechHistoryDepartmentDataPolicy;
use App\GraduateDepartmentHistoryData;
use App\Policies\GraduateDepartmentHistoryDataPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        SchoolHistoryData::class => SchoolHistoryDataPolicy::class,
        SystemHistoryData::class => SystemHistoryDataPolicy::class,
//        SystemQuota::class => SystemQuotaPolicy::class,
        DepartmentHistoryData::class => DepartmentHistoryDataPolicy::class,
        TwoYearTechHistoryDepartmentData::class => TwoYearTechHistoryDepartmentDataPolicy::class,
        GraduateDepartmentHistoryData::class => GraduateDepartmentHistoryDataPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
