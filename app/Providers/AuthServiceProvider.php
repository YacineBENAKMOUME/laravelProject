<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('isRst', function($user){
            return $user->type == "RST";
        });

        $gate->define('isRsf', function($user){
            return $user->type == "RSF";
        });

        $gate->define('isRelex', function($user){
            return $user->type == "Relex";
        });

        $gate->define('isChefdepartement', function($user){
            return $user->type == "Chef de Département";
        });

    }
}
