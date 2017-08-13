<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

use App\AppSwitchData;

use DB;
use Log;

class AppSwitch
{
    /**
     * Create a new middleware instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 白名單的 function
        $this->whiteList = collect([

        ]);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $method = Route::currentRouteAction();

        $app_switch_data = new AppSwitchData();

        if ( $this->whiteList->contains($method) ) {
            $db_now = DB::raw('NOW()');

            if ( !$app_switch_data->where([
                ['function', '=', $method],
                ['start_at', '>=', $db_now],
                ['end_at', '<=', $db_now]
            ])->exists() ) {
                return response()->json([
                    'messages' => ['本功能暫時無法使用']
                ], 503);
            }
        }

        Log::info($method);

        return $next($request);
    }
}
