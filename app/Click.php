<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{

    protected $table = 'ps_clicks';

    protected $fillable = ['user_id','user_name','coordX','coordY','url','fecha','dispositivo','product_id'];

    public $timestamps = false;

    public $dates = ['fecha'];

    public function product()
    {
        return $this->belongsTo('App\Product','product_id','id_product');
    }

}
