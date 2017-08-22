<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\AppSwitchData;

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

    /** @var AppSwitchData */
    private $AppSwitchDataModel;

    /**
     * Create a new command instance.
     *
     * @param AppSwitchData $AppSwitchDataModel
     *
     * @return void
     */
    public function __construct(AppSwitchData $AppSwitchDataModel)
    {
        parent::__construct();

        $this->AppSwitchDataModel = $AppSwitchDataModel;
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
                        if ( $this->AppSwitchDataModel->where('function', '=', $action['controller'])->exists() ) {
                            $switch_data = $this->AppSwitchDataModel->where('function', '=', $action['controller'])->first();

                            $controllers[] = [$action['controller'], $switch_data->start_at, $switch_data->end_at];
                        } else {
                            $controllers[] = [$action['controller'], '', ''];
                        }

                        break;
                    }
                }
            }
        }

        $headers = ['Function', 'Start_at', 'End_at'];

        $this->table($headers, $controllers);
    }
}
