<?php

namespace App\Http\Controllers;

use App\Click;
use Illuminate\Http\Request;

use App\Http\Requests;

class TopController extends Controller
{
    public function clicksAndPercentage(Request $request)
    {
        if ($request->input('simple'))
            return view('reports.products.top-simple');

        return view('reports.products.top');
    }

    public function sourceProducts(Request $request)
    {
        // input params
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $topLimit = $request->input('top') ?: 3;

        // get all clicks
        if ($start_date && $end_date) {
            $clicks = Click::whereNotNull('product_id')->where('product_id', '<>', 0)
                ->whereBetween('fecha', [$start_date, $end_date])
                ->get();
        } else {
            $clicks = Click::whereNotNull('product_id')
                ->where('product_id', '<>', 0)->get();
        }

        // initialize arrays
        $productNames = [];
        $productIds = [];
        $deviceTypes = [];
        $uniqueIds = [];
        $topProducts = []; // product, quantity

        // calc the tick percent
        $nClicks = sizeof($clicks);
        if ($nClicks > 0)
            $tickPercent = 100 / $nClicks;
        else
            $tickPercent = 0;

        // take the product ids and names
        foreach ($clicks as $click) {
            $productIds[] = $click->product->id_product;
            $productNames[] = $click->product->name;

            if ($click->dispositivo == 'desktop')
                $deviceTypes[] = 'desktop';
            else
                $deviceTypes[] = 'mobile';
        }

        for ($i=0; $i<sizeof($productIds); ++$i) {

            $j = $this->getPositionIn($productIds[$i], $uniqueIds);
            if ($j == -1) {
                $uniqueIds[] = $productIds[$i];

                $newItem = [];
                $newItem['product'] = $productNames[$i];
                $newItem['quantity'] = 1;
                if ($deviceTypes[$i] == 'desktop') {
                    $newItem['desktop'] = 1;
                    $newItem['mobile'] = 0;
                } else {
                    $newItem['desktop'] = 0;
                    $newItem['mobile'] = 1;
                }
                $newItem['percent'] = $tickPercent;

                $topProducts[] = $newItem;

            } else {
                if ($deviceTypes[$i] == 'desktop') {
                    $topProducts[$j]['desktop'] += 1;
                } else {
                    $topProducts[$j]['mobile'] += 1;
                }
                $topProducts[$j]['quantity'] += 1;
                $topProducts[$j]['percent'] += $tickPercent;
            }
        }

        $orderedTop = $this->bubbleSortPairs($topProducts);
        $data['products'] = array_slice($orderedTop, 0, $topLimit);

        return $data;
    }

    public function productTopData(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $topLimit = $request->input('top') ?: 3;

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

            } else {
                $pairs[$j]['quantity'] += 1;
                $pairs[$j]['percent'] += $tickPercent;
            }
        }

        $orderedPairs = $this->bubbleSortPairs($pairs);
        $data['pairs'] = array_slice($orderedPairs, 0, $topLimit);

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

    public function matrix(Request $request)
    {
        if ($request->input('simple'))
            return view('reports.products.matrix-simple');

        return view('reports.products.matrix');
    }

    public function peakHoursMatrix(Request $request)
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

        $tickPercentage = 100 / sizeof($clicks);

        $data = []; // $i -> day of week from 0 to 6
        for ($i=0; $i<7; ++$i) {
            // $data[$i]['total'] = 0;
            for ($h=0; $h<=23; ++$h) {
                $cell = [];
                $cell['q'] = 0; // quantity
                $cell['p'] = 0; // percentage
                $data[$i][$h] = $cell;
            }

        }

        foreach ($clicks as $click) {
            // $data[$click->fecha->dayOfWeek]['total'] += 1;
            $cell = $data[$click->fecha->dayOfWeek][$click->fecha->hour];
            $cell['q'] += 1;
            $cell['p'] += $tickPercentage;

            $data[$click->fecha->dayOfWeek][$click->fecha->hour] = $cell;
        }

        // iterate each dayOfWeek
        // and determine the peak hour
        /*$peaks = [];
        for ($i=0; $i<7; ++$i) {
            $peakHour = 0;
            for ($h=1; $h<=23; ++$h) {
                if ($data[$i][$h] > $data[$i][$peakHour])
                    $peakHour = $h;
            }

            $peaks[$i] = $peakHour;
        }*/

        return $data;
    }

    public function byCountry(Request $request)
    {
        // SELECT DISTINCT country_code FROM `ps_clicks` WHERE country_code<>''
        Click::where('country_code', '<>', '')->distinct()->pluck('country_code');
        return view('reports.country')->with(compact('countries'));
    }
}
