<?php

namespace Kopp\Policies;

use Kopp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // Права на резервное копирование базы данных
    public function backup(User $user)
    {
        // Только администратор
        foreach ($user->roles as $role) {
            if ('Administrator' == $role->name) {
                return true;
            }
        }
        return false;
    }
}
