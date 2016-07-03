<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Click;
use App\Http\Requests;

class DataController extends Controller
{
    public function mining()
    {
        $countries = Click::distinct()->select('country')->pluck('country');
        return view('data.mining')->with(compact('countries'));
    }
}
