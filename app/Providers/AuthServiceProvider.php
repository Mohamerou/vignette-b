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

        Gate::define('prevision', function($user){
            if($user->hasRole('elu'))
                return $user->hasRole('elu');
            
            if($user->hasRole('comptable-public'))
                return $user->hasRole('comptable-public');

            if($user->hasRole('dfm'))
                return $user->hasRole('dfm');

            if($user->hasRole('ordonnateur'))
                return $user->hasRole('ordonnateur');
                
            if($user->hasRole('controle-gestion'))
                return $user->hasRole('controle-gestion');
        });

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

        Gate::define('regisseur', function($user){
            return $user->hasRole('regisseur');
        });

        Gate::define('caissier-en-chef', function($user){
            return $user->hasRole('caissier-en-chef');
        });

        Gate::define('comptable-public', function($user){
            if($user->hasRole('caissier-en-chef'))
                return $user->hasRole('caissier-en-chef');
            
            if($user->hasRole('comptable-public'))
                return $user->hasRole('comptable-public');

        });

        

        Gate::define('intern', function($user){
            
            if($user->hasRole('superadmin'))
                return $user->hasRole('superadmin');

            if($user->hasRole('elu'))
                return $user->hasRole('elu');
            
            if($user->hasRole('dfm'))
                return $user->hasRole('dfm');

            if($user->hasRole('ordonateur'))
                return $user->hasRole('ordonateur');

            if($user->hasRole('controle-gestion'))
                return $user->hasRole('controle-gestion');
                
            if($user->hasRole('caissier-en-chef'))
                return $user->hasRole('caissier-en-chef');
        
            if($user->hasRole('comptable-public'))
                return $user->hasRole('comptable-public');
    
            if($user->hasRole('regisseur'))
                return $user->hasRole('regisseur');
    
            if($user->hasRole('guichet'))
                return $user->hasRole('guichet');
        });

        

        Gate::define('read-report', function($user){
            
            if($user->hasRole('elu'))
                return $user->hasRole('elu');
            
            if($user->hasRole('dfm'))
                return $user->hasRole('dfm');

            if($user->hasRole('ordonateur'))
                return $user->hasRole('ordonateur');

            if($user->hasRole('controle-gestion'))
                return $user->hasRole('controle-gestion');
                
            if($user->hasRole('caissier-en-chef'))
                return $user->hasRole('caissier-en-chef');
    
            if($user->hasRole('regisseur'))
                return $user->hasRole('regisseur');
        });

        

        Gate::define('all', function($user){
            
            if($user->hasRole('superadmin'))
                return $user->hasRole('superadmin');

            if($user->hasRole('elu'))
                return $user->hasRole('elu');
            
            if($user->hasRole('dfm'))
                return $user->hasRole('dfm');

            if($user->hasRole('ordonateur'))
                return $user->hasRole('ordonateur');

            if($user->hasRole('controle-gestion'))
                return $user->hasRole('controle-gestion');
                
            if($user->hasRole('caissier-en-chef'))
                return $user->hasRole('caissier-en-chef');
        
            if($user->hasRole('comptable-public'))
            return $user->hasRole('comptable-public'); 
        
            if($user->hasRole('regisseur'))
            return $user->hasRole('regisseur');  

            if($user->hasRole('user'))
                return $user->hasRole('user');
                
            if($user->hasRole('guichet'))
                return $user->hasRole('guichet');

        });

    }
}
