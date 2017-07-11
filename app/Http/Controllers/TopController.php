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
        $topLimit = $request->input('top');

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
        $pairs = []; // product, quantity
        $tickPercent = 100 / sizeof($clicks);

        foreach ($clicks as $click) {
            $allProductIds[] = $click->product->id_product;
            $allLabels[] = $click->product->name;
        }

        for ($i=0; $i<sizeof($allProductIds); ++$i)
        {
            $j = $this->getPositionIn($allProductIds[$i], $productIds);
            if ($j == -1) {
                $productIds[] = $allProductIds[$i];

                $newItem = [];
                $newItem['product'] = $allLabels[$i];
                $newItem['quantity'] = 1;
                $newItem['percent'] = $tickPercent;

                $pairs[] = $newItem;

                if ($topLimit && sizeof($pairs) >= $topLimit) // if there is a limit
                    break;
            } else {
                $pairs[$j]['quantity'] += 1;
                $pairs[$j]['percent'] += $tickPercent;
            }
        }

        $this->bubbleSortPairs($pairs);
        $data['pairs'] = $pairs;
        return $data;
    }

    public function getPositionIn($product, $products) {
        for ($i=0; $i < sizeof($products); $i++) {
            if ($product == $products[$i])
                return $i;
        }
        return -1;
    }

    function bubbleSortPairs($pairs)
    {
        $array_count = count($pairs);

        for ($x=0; $x<$array_count; $x++){
            for($a=0;  $a<$array_count-1; $a++){
                if ($a<$array_count) {
                    if ($pairs[$a]['quantity'] > $pairs[$a + 1]['quantity']) {
                        $this->swap($pairs, $a, $a+1);
                    }
                }
            }
        }

        return $pairs;
    }

    function swap(&$arr, $a, $b) {
        $tmp = $arr[$a];
        $arr[$a] = $arr[$b];
        $arr[$b] = $tmp;
    }
}
