<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminControllerPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function hasAdmin(User $user): bool
    {
        return $user->id == Auth::id() || $user->hasRole('admin');
    }

    /**
     * @param User $user
     * @param int $id
     * @return bool
     */
    public function userUpdate(User $user, int $id):bool
    {
        return $user->id == $id || $user->hasRole('admin');
    }

    /**
     * @param User $user
     * @param int $id
     * @return bool
     */
    public function userEdit(User $user, int $id):bool
    {
        return $user->id == $id || $user->hasRole('admin');
    }
}
