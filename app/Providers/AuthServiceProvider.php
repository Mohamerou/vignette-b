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

        Gate::define('guichet', function($user){
            return $user->hasRole('guichet');
        });

        Gate::define('elu', function($user){
            if($user->hasRole('elu'))
                return $user->hasRole('elu');
            
            if($user->hasRole('dfm'))
                return $user->hasRole('dfm');

            if($user->hasRole('ordonateur'))
                return $user->hasRole('ordonateur');

            if($user->hasRole('controle-gestion'))
                return $user->hasRole('controle-gestion');
        });

        Gate::define('regisseur-public', function($user){
            return $user->hasRole('regisseur-public');
        });

        Gate::define('superviseur', function($user){
            return $user->hasRole('superviseur');
        });

        Gate::define('comptable-public', function($user){
            if($user->hasRole('superviseur'))
                return $user->hasRole('superviseur');
            
            if($user->hasRole('comptable-public'))
                return $user->hasRole('comptable-public');

        });

    }
}
