<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

use App\Policies\User_P;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Paginator::useBootstrap();

        Gate::define('access-user', function ($user) {
             return in_array( $user->role, 
                ['superadmin', 'admin']
            );
        });

        Gate::define('access-role', function ($user) {
             return in_array( $user->role, 
                ['superadmin']
            );
        });

        Gate::define('access-master', function ($user) {
             return in_array( $user->role, 
                ['superadmin', 'admin', 'office']
            );
        });

        Gate::define('access-inventory', function ($user) {
             return in_array( $user->role, 
                ['superadmin', 'admin', 'office']
            );
        });

        Gate::define('access-purchasing', function ($user) {
             return in_array( $user->role, 
                ['superadmin', 'admin', 'office']
            );
        });

        Gate::define('access-production', function ($user) {
             return in_array( $user->role, 
                ['superadmin', 'admin', 'office']
            );
        });

        Gate::define('is-production', function ($user) {
             return in_array( $user->role, 
                ['production']
            );
        });

        Gate::define('access-report', function ($user) {
             return in_array( $user->role, 
                ['superadmin', 'admin', 'office', 'production']
            );
        });



    }
}
