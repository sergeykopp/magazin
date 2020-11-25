<?php

namespace Kopp;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    public $timestamps = false; // Не использовать поля created_at и updated_at

    // Заказы
    public function orders()
    {
        return $this->hasMany('Kopp\Order', 'status_id', 'id');
    }
}
