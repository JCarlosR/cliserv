<?php

namespace App\Http\Controllers;

use App\Click;
use Illuminate\Http\Request;

use App\Http\Requests;

class TopController extends Controller
{
    public function clicksAndPercentage()
    {
        $products = Click::whereNotNull('product_id')->get();
        dd($products);
    }
}
