<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Eloquents\EloquentUser;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Eloquents\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();

        // // 管理者ユーザー
        // Gate::define('admin', function (User $user) {
        //     return $user->role === User::ADMIN;
        // });
        // // 一般ユーザー
        // Gate::define('general', function (User $user) {
        //     return $user->role === User::GENERAL;
        // });
    }
}
