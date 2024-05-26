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
        return true; // Администратор может редактировать любые объявления
    }

    public function delete(User $user, Ad $ad)
    {
        return true; // Администратор может удалять любые объявления
    }

    public function deleteComment(User $user)
    {
        return true; // Администратор может удалять комментарии
    }

    public function deleteUser(User $user)
    {
        return true; // Администратор может удалять пользователей
    }
}
