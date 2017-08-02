<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'ps_product_lang';

    protected $fillable = ['id_product','name','id_lang'];

    public $timestamps = false;

    public function category()
    {
        return $this->hasMany('App\Category','product_id');
    }

    public function picture()
    {
        return $this->hasMany('App\Picture','id_product');
    }

}