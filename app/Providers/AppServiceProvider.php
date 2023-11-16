<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with('user', Auth::user());
            $view->with('projectId', 0);
        });

        if ($this->app['livewire']->isLivewireRequest()) {
            $this->bypassMiddleware([
                TrimStrings::class,
                ConvertEmptyStringsToNull::class,
            ]);
        }

        Blade::if('roles', function (array $roles) { 
            return Auth::check() 
                && in_array(Auth::user()->role, $roles, true); 
        });
    }

    protected function bypassMiddleware(array $middlewareToExclude)
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        
        $openKernel = new ObjectPrybar($kernel);
        
        $middleware = $openKernel->getProperty('middleware');
        
        $openKernel->setProperty('middleware', array_diff($middleware, $middlewareToExclude));
    }

    
}
