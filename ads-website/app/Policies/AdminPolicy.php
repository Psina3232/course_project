<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ad;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Ad $ad)
    {
        return true; 
    }

    public function delete(User $user, Ad $ad)
    {
        return true; 
    }

    public function deleteComment(User $user)
    {
        return true; 
    }

    public function deleteUser(User $user)
    {
        return true; 
    }
}
