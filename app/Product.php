<?php

namespace Kopp;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false; // Не использовать поля created_at и updated_at

    // Категория
    public function category()
    {
        return $this->belongsTo('Kopp\Category', 'category_id', 'id');
    }

    // Бренд
    public function brand()
    {
        return $this->belongsTo('Kopp\Brand', 'brand_id', 'id');
    }

    // Заказы через таблицу order_products
    public function orders()
    {
        return $this->belongsToMany('Kopp\Order', 'order_products', 'product_id', 'order_id');
    }
}
