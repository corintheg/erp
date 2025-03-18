<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('manage-users', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('view-finances', function (User $user) {
            return in_array($user->role, ['admin', 'finance', '']);
        });
    }
}
