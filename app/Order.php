<?php

namespace Kopp;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false; // Не использовать поля created_at и updated_at

    // Продукты
    public function products()
    {
        return $this->hasMany('Kopp\OrderProduct', 'order_id', 'id');
    }

    // Статус
    public function status()
    {
        return $this->belongsTo('Kopp\OrderStatus', 'status_id', 'id');
    }

    // Прользователь
    public function user()
    {
        return $this->belongsTo('Kopp\User', 'user_id', 'id');
    }
}
