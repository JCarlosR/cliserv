<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DataController extends Controller
{

    public function mining()
    {
        return view('data.mining');
    }

}
