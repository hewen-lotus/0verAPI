<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App;
use Route;

class ListSwitchedRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:list-switch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '列出可以控制開關的 Controller';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $controllers = [];

        foreach (Route::getRoutes()->getRoutes() as $route)
        {
            $action = $route->getAction();

            if (array_key_exists('controller', $action))
            {
                $segments = explode('@', $action['controller']);

                $controller = App::make($segments[0]);

                $middlewares = $controller->getMiddleware();

                foreach ($middlewares as $middleware) {
                    if ($middleware['middleware'] == 'switch') {
                        $controllers[] = $action['controller'];

                        $this->info($action['controller']);

                        break;
                    }
                }
            }
        }
    }
}
