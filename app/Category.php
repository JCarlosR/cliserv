<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'ps_category';

    // Cuando se usa create
    // protected $fillable = [''];

    public function categoryname()
    {
        return $this->belongsTo('App\CategoryName','id_category','id_category');
    }
}
