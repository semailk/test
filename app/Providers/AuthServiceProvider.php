<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
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

        Gate::define('show-post', function (User $user, Post $post) {
            return $user->id === $post->user_id || $post->public === 1;
        });

        Gate::define('deleteOrUpdatePost', function (User $user, Post $post){
           return $user->role === 'admin' || $post->user_id === $user->id;
        });

        Gate::define('avatarStore', function (User $user){
           return $user->id === auth()->id() || $user->role === 'admin';
        });

        Gate::define('isAdmin', function (User $user){
           return $user->role === 'admin';
        });
    }
}
