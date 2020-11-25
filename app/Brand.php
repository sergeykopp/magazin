<?php

namespace Kopp;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false; // Не использовать поля created_at и updated_at

    // Продукты
    public function products()
    {
        return $this->hasMany('Kopp\Product', 'brand_id', 'id');
    }
}
