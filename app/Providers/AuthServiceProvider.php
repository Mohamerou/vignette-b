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

        Gate::define('user', function($user){
            return $user->hasRole('user');
        });

        Gate::define('agent_vente', function($user){
            return $user->hasRole('agent_vente');
        });

        Gate::define('agent_enroll', function($user){
            return $user->hasRole('agent_enroll');
        });

        Gate::define('elu', function($user){
            return $user->hasRole('elu');
        });

        Gate::define('reporteur', function($user){
            return $user->hasRole('reporteur');
        });

        Gate::define('superviseur', function($user){
            return $user->hasRole('superviseur');
        });

    }
}
