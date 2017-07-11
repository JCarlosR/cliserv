<?php

namespace App\Http\Controllers;

use App\Click;
use Illuminate\Http\Request;

use App\Http\Requests;

class TopController extends Controller
{
    public function clicksAndPercentage()
    {
        return view('reports.products.top');
    }

    public function productTopData(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $topLimit = $request->input('top') ?: 5;

        if ($start_date && $end_date) {
            $clicks = Click::whereNotNull('product_id')
                ->where('product_id', '<>', 0)
                ->whereBetween('fecha', [$start_date, $end_date])
                ->get();
        } else {
            $clicks = Click::whereNotNull('product_id')
                ->where('product_id', '<>', 0)->get();
        }

        $allLabels = [];
        $allProductIds = [];
        $productIds = [];
        $labels = [];
        $quantity = [];

        foreach($clicks as $click) {
            $allProductIds[] = $click->product->id_product;
            $allLabels[] = $click->product->name;
        }

        for ($i=0; $i<sizeof($allProductIds); ++$i)
        {
            $j = $this->getPositionIn($allProductIds[$i], $productIds);
            if ($j == -1) {
                $productIds[] = $allProductIds[$i];
                $labels[] = $allLabels[$i];
                $quantity[] = 1;

                if (sizeof($quantity) >= $topLimit) // ==
                    break;
            } else
                $quantity[$j]++;
        }

        $data['products'] = $labels;
        $data['quantities'] = $quantity;
        return $data;
    }
}
