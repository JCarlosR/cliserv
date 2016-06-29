<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product
{

    protected $table = 'ps_product';

    protected $fillable = ['id_product','reference'];

    public $timestamps = false;

    public function click()
    {
        
    }
}