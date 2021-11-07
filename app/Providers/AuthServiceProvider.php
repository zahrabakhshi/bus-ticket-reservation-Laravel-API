<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
//    protected $policies = [
//         'App\Models\Model' => 'App\Policies\ModelPolicy',
//    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) { //TODO: what dose this line DO?
            Passport::routes();
        }

        //define gates for user access level

        Gate::define('adminGate',function (User $user){
            //if roles of given user contain 'admin' role gate return true else return false
            return in_array('admin' ,array_column($user->roles->toArray(),'name'));
        });

        Gate::define('companyGate', function (User $user){
            //if roles of given user contain 'company' role gate return true else return false
            return in_array('company' ,array_column($user->roles->toArray(),'name'));
        });

        Gate::define('superAdminGate', function (User $user){
            //if roles of given user contain 'super-admin' role gate return true else return false
            return in_array('super-admin' ,array_column($user->roles->toArray(),'name'));
        });

    }
}
