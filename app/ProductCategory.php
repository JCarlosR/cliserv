<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{

    protected $table = 'ps_product';

    protected $fillable = ['id_product','reference'];

    public $timestamps = false;


}