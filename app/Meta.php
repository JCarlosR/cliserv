<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $fillable = ['cantidad','numero'];
    protected $table = 'ps_metas';
}
