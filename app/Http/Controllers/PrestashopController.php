<?php

namespace App\Http\Controllers;

use App\Click;
use App\GeneralProduct;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class PrestashopController extends Controller
{
    public function index(Request $request)
    {
        $customerId = $request->input('id');
        $customerName = $request->input('name');

        // get the most viewed products for the specified user
        $productIds = Click::select(['product_id', DB::raw('COUNT(1) as total')])
            ->where('user_id', $customerId)
            ->whereNotNull('product_id')->where('product_id','!=',0)
            ->groupBy('product_id')
            ->orderBy('total', 'desc')
            ->pluck('product_id');

        $idsOrdered = implode(',', $productIds);

        $products = Product::whereIn('id_product', $productIds)
            ->where('id_lang', 1)
            ->orderByRaw(DB::raw("FIELD(id, $idsOrdered)"))
            ->get();

        foreach ($products as $product) {
            $product->price = GeneralProduct::where('id_product', $product->id_product)->first()->price;
        }

        return view('prestashop.index')->with(compact('customerName', 'products'));
    }
}
