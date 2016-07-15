<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $fillable = ['cantidad','celular'];
    protected $table = 'ps_metas';
}
