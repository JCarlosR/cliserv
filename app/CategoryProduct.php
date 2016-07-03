<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = 'ps_category_product';

    public function product()
    {
        return $this->belongsTo('App\Product','id_product','id_product');
    }

    public function category()
    {
        return $this->belongsTo('App\Category','id_category','id_category');
    }
}
