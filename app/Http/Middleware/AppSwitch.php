<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Foundation\Application;

use App\AppSwitchData;

use DB;
use Log;

class AppSwitch
{
    /**
     * The application implementation.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
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

        Log::info($method);

        if ( $this->app->environment() != 'local' ) {
            $app_switch_data = new AppSwitchData();

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

        return $next($request);
    }
}
