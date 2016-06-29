<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryName extends Model
{
    protected $table = 'ps_category_lang';

    public function category()
    {
        return $this->belongsTo('App\Category','id_category','id_category');
    }
}
