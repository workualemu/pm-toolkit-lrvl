<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
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

        Blade::if('role', function (string|array $roles, ?string $guard = null) {
            $user = Auth::guard($guard)->user();
            $roles = (array) $roles;
            return $user?->hasAnyRole($roles) ?? false;
        });
        Blade::if('permission', function (string|array $permissions, ?string $guard = null) {
            $user = Auth::guard($guard)->user();
            $permissions = (array) $permissions;
            return $user?->hasAnyPermission($permissions) ?? false;
        });

        Task::observe(TaskDateObserver::class);

        Livewire::component('privacy-modal', \App\Http\Livewire\PrivacyModal::class);
        Livewire::component('terms-modal', \App\Http\Livewire\TermsModal::class);
    
    }
    
}
