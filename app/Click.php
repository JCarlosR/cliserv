<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{

    protected $table = 'ps_clicks';

    protected $fillable = ['user_id','user_name','coordX','coordY','url','fecha','dispositivo'];

    public $timestamps = false;

    public $dates = ['fecha'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id_customer');
    }

}
