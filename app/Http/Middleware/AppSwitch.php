<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

use App\AppSwitchData;
use Log;

class AppSwitch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
        if ($this->app->isDownForMaintenance()) {
            return response()->json([
                'messages' => ['Server is under Maintenance']
            ], 503);
         }
         */

        Log::info(Route::currentRouteAction());

        return $next($request);
    }
}
