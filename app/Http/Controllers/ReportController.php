<?php

namespace App\Http\Controllers;

use App\Click;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReportController extends Controller
{
    public function byUserType()
    {
        $clicks = Click::all();

        $user_clicks = [];
        $visitors_clicks = [];
        // January - June
        for ($i=0; $i<6; ++$i) {
            $user_clicks[$i] = 0;
            $visitors_clicks[$i] = 0;
        }

        foreach ($clicks as $click) {
            $month = $click->fecha->month;
            if ($month != 11) {
                // Add click to users or visitors
                if ($click->user_name == 'Visitante')
                    $visitors_clicks[$month - 1]++;
                else
                    $user_clicks[$month - 1]++;
            }

        }

        $data['users'] = $user_clicks;
        $data['visitors'] = $visitors_clicks;
        return $data;
    }

    public function byDeviceType()
    {
        $clicks = Click::all();

        $desktop_clicks = [];
        $mobile_clicks = [];
        // January - June
        for ($i=0; $i<6; ++$i) {
            $desktop_clicks[$i] = 0;
            $mobile_clicks[$i] = 0;
        }

        foreach ($clicks as $click) {
            $month = $click->fecha->month;
            if ($month != 11) {
                // Add click to desktop or mobile arrays
                if ($click->dispositivo == 'desktop')
                    $desktop_clicks[$month - 1]++;
                else
                    $mobile_clicks[$month - 1]++;
            }

        }

        $data['desktop'] = $desktop_clicks;
        $data['mobile'] = $mobile_clicks;
        return $data;
    }

    public function byProducts()
    {
        $clicks = Click::wherenotnull('product_id')->where('product_id','<>',0)->get();
        $labelproducts = [];
        $idproducts = [];
        $arrayproducts = [];
        $quantity = [];

        foreach($clicks as $click)
        {
            $idproducts[] = $click->product->id_product;
            $labelproducts[] = $click->product->name;
        }

        for ($i=0; $i<sizeof($idproducts); ++$i)
        {
            $j = $this->verOcurrencia($idproducts[$i], $arrayproducts);
            if($j != -1)
                $quantity[$j]++;
            else{
                $arrayproducts[] = $idproducts[$i];
                $arraylabels[] = $labelproducts[$i];
                $quantity[]=1;
            }
        }

        $data['products'] = $arraylabels;
        $data['quantity'] = $quantity;
        return $data;
    }

    public function verOcurrencia($producto,$productos){
        for($i =0 ; $i< sizeof($productos); $i++){
            if($producto==$productos[$i])
                return $i;
        }
        return -1;
    }

}
