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

        $nClicks = sizeof($clicks);
        if ($nClicks > 0)
            $tickPercent = 100 / $nClicks;
        else
            $tickPercent = 0;

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
                    break; // (?) we should find the last pair in the next clicks
            } else {
                $pairs[$j]['quantity'] += 1;
                $pairs[$j]['percent'] += $tickPercent;
            }
        }

        $data['pairs'] = $this->bubbleSortPairs($pairs);
        return $data;
    }

    public function getPositionIn($product, $products) {
        for ($i=0; $i < sizeof($products); $i++) {
            if ($product == $products[$i])
                return $i;
        }
        return -1;
    }

    public function bubbleSortPairs($pairs)
    {
        $array_count = count($pairs);

        for ($x=0; $x<$array_count; $x++){
            for($a=0;  $a<$array_count-1; $a++){
                if ($a<$array_count) {
                    if ($pairs[$a]['quantity'] < $pairs[$a + 1]['quantity']) {
                        $this->swap($pairs, $a, $a+1);
                    }
                }
            }
        }

        return $pairs;
    }

    public function swap(&$arr, $a, $b)
    {
        $tmp = $arr[$a];
        $arr[$a] = $arr[$b];
        $arr[$b] = $tmp;
    }

    public function peakHoursData(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if ($start_date && $end_date) {
            $clicks = Click::whereNotNull('product_id')
                ->where('product_id', '<>', 0)
                ->whereBetween('fecha', [$start_date, $end_date])
                ->get();
        } else {
            $clicks = Click::whereNotNull('product_id')
                ->where('product_id', '<>', 0)->get();
        }

        $data = []; // $i -> day of week from 0 to 6
        for ($i=0; $i<7; ++$i) {
            // $data[$i]['total'] = 0;
            for ($h=0; $h<=23; ++$h)
                $data[$i][$h] = 0;
        }

        foreach ($clicks as $click) {
            // $data[$click->fecha->dayOfWeek]['total'] += 1;
            $data[$click->fecha->dayOfWeek][$click->fecha->hour] += 1;
        }

        // iterate each dayOfWeek
        // and determine the peak hour
        $peaks = [];
        for ($i=0; $i<7; ++$i) {
            $peakHour = 0;
            for ($h=1; $h<=23; ++$h) {
                if ($data[$i][$h] > $data[$i][$peakHour])
                    $peakHour = $h;
            }

            $peaks[$i] = $peakHour;
        }

        return $peaks;
    }
}
