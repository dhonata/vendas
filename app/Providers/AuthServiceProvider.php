<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        Gate::define('sell', function ($user) {

            if ($user->role == 'adm' || $user->role == 'seller'){
                return true;
            }

            return false;

        });

        Gate::define('adm', function ($user) {

            if ($user->role == 'adm'){
                return true;
            }

            return false;

        });

    }
}
