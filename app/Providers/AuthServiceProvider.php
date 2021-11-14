<?php

namespace App\Providers;

use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
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

//        Gate::define('adminGate',function (User $user){
//            //if roles of given user contain 'admin' role gate return true else return false
//            return in_array('admin' ,$user->roles()->pluck('name')->toArray());
//        });
//
//        Gate::define('companyGate', function (User $user){
//            //if roles of given user contain 'dashboards' role gate return true else return false
//            return in_array('company' ,$user->roles()->pluck('name')->toArray());
//        });
//
//        Gate::define('superAdminGate', function (User $user){
//            //if roles of given user contain 'super-admin' role gate return true else return false
//            return in_array('super-admin' ,$user->roles()->pluck('name')->toArray());
//        });

//        Gate::define('userGate', function (User $user){
//            //if roles of given user contain 'super-admin' role gate return true else return false
//            return in_array('user' ,$user->roles()->pluck('name')->toArray());
//        });

        Gate::define('update-vehicle', function (User $user, Vehicle $vehicle) {
            return $user->id == $vehicle->company_id;
        });
        Gate::define('update-trip', function (User $user, Trip $trip) {
            return $user->id == $trip->vehicle()->first()->company_id;
        });


    }
}
