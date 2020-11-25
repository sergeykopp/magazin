<?php

namespace Kopp;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false; // Не использовать поля created_at и updated_at

    // Пользователи через таблицу role_user
    public function users()
    {
        return $this->belongsToMany('Kopp\User', 'role_user', 'role_id', 'user_id');
    }
}
