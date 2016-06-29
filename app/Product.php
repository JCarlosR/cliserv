<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'ps_product';

    protected $fillable = ['id_product','reference'];

    public $timestamps = false;

    public function category()
    {
        return $this->hasMany('App\Category','product_id');
    }


}