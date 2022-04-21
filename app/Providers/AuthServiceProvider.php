<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
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

        Gate::define('superadmin', function($user){
            return $user->hasRole('superadmin');
        });

        Gate::define('user', function($user){
            return $user->hasRole('user');
        });

        Gate::define('agent', function($user){
            return $user->hasRole('agent');
        });

        Gate::define('elu', function($user){
            return $user->hasRole('elu');
        });

        Gate::define('regisseur', function($user){
            return $user->hasRole('regisseur');
        });

        Gate::define('superviseur', function($user){
            return $user->hasRole('superviseur');
        });

        Gate::define('direction', function($user){
            return $user->hasRole('direction');
        });

        Gate::define('comptable', function($user){
            if($user->hasRole('superviseur'))
                return $user->hasRole('superviseur');
            
            if($user->hasRole('comptable'))
                return $user->hasRole('comptable');

        });

    }
}
