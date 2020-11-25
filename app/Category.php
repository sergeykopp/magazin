<?php

namespace Kopp;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false; // Не использовать поля created_at и updated_at

    // Продукты
    public function products()
    {
        return $this->hasMany('Kopp\Product', 'category_id', 'id');
    }

    // Родительская категория
    public function parent()
    {
        return $this->belongsTo('Kopp\Category', 'category_id', 'id');
    }

    // Подкатегории
    public function children()
    {
        return $this->hasMany('Kopp\Category', 'category_id', 'id');
    }
}
