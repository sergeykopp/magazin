<?php

namespace Kopp;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    public $timestamps = false; // Не использовать поля created_at и updated_at

    // Заказ
    public function order()
    {
        return $this->belongsTo('Kopp\Order', 'order_id', 'id');
    }

    // Товар
    public function product()
    {
        return $this->belongsTo('Kopp\Product', 'product_id', 'id');
    }
}
