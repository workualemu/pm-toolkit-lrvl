<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use App\Observers\TaskDateObserver;
use App\Models\Task;
use Livewire\Livewire;


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

        Blade::if('roles', function (array $roles) { 
            return Auth::check() 
                && in_array(Auth::user()->role, $roles, true); 
        });

        Task::observe(TaskDateObserver::class);

        Livewire::component('privacy-modal', \App\Http\Livewire\PrivacyModal::class);
        Livewire::component('terms-modal', \App\Http\Livewire\TermsModal::class);
    
    }
    
}
