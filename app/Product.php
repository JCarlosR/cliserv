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
        return $this->belongsTo('App\Category','id_category','id_category'); // (?)
    }

    public function pictures()
    {
        return $this->hasMany('App\Picture','id_product','id_product');
    }

    public function getPictureAttribute()
    {
        return $this->pictures()->first();
    }

    public function getCategoryNameAttribute()
    {
        $id_category = CategoryProduct::where('id_product', $this->id_product)->first()->id_category;
        return CategoryName::where('id_lang',1)
            ->where('id_category', $id_category)
            ->orderBy('position', 'asc')
            ->first();
    }
}