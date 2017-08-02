<?php

namespace App\Http\Controllers;

use App\Click;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;

class PrestashopController extends Controller
{
    public function index(Request $request)
    {
        $customerId = $request->input('id');
        $customerName = $request->input('name');

        // get the most viewed products for the specified user
        $productIds = Click::select('ps_clicks.product_id, count(1) as total')
            ->where('user_id', $customerId)
            ->whereNotNull('product_id')->where('product_id','!=',0)
            ->groupBy('product_id')
            ->orderBy('total', 'desc')
            ->pluck('product_id');

        $products = Product::whereIn('id_product', $productIds)
            ->where('id_lang', 1)
            ->get();
        dd($products);

        return view('prestashop.index')->with(compact('customerName'));
    }
}
