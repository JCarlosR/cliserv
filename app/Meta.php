<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'ps_metas';
    protected $fillable = ['cantidad','celular'];
}
