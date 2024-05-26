<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\User;
use App\Policies\AdminPolicy;


class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Ad::class => AdminPolicy::class,
        User::class => AdminPolicy::class,
    ];
}
