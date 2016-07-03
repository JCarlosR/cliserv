<?php

namespace App\Http\Controllers;

use App\Click;
use App\Http\Requests;
use Carbon\Carbon;

class ClickController extends Controller
{

    public function welcome(){
        return view('welcome');
    }

    public function tendencia()
    {
        $today  = Carbon::today();
        $clicks = Click::where('fecha','<=',$today)->get();

        $category_arrays = []; // Available categories according to clicks data(product_id)

        foreach( $clicks as $click )
        {
            $url = $click->url;
            if( $url !='' )
            {
                $string = str_ireplace('http://cliserv.esy.es/es/','',$url);
                if ( is_numeric( substr($string,0,1) ) )
                    if (!$this->repeated_element($category_arrays, substr($string,0,1)))
                        $category_arrays[] = substr($string,0,1);
            }
        }
        dd($category_arrays);
    }

    public function general($finicio=null, $ffin=null)
    {
        if ($finicio && $ffin) {
            $clicks = Click::where('fecha','>=',$finicio)->where('fecha','<',$ffin)->get();
            return response()->json($clicks);
        }



        $clicks = Click::orderBy('created_at','desc')->take(3);
        return view('general')->with(compact('clicks'));
    }

    public function software()
    {
        return view('software');
    }

    public function web()
    {
        return view('web');
    }

    public function hours()
    {
        return view('hours');
    }

    public function products()
    {
        return view('topproducts');
    }

    public function pages()
    {
        return view('pages');
    }

    public function traffic()
    {
        return view('traffic');
    }

    public function repeated_element( $year,$element )
    {
        for( $i=0;$i<count($year);$i++ )
        {
            if( $year[$i] == $element )
                return true;
        }
        return false;
    }

}