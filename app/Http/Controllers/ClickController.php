<?php

namespace App\Http\Controllers;

use App\Click;
use App\Http\Requests;

class ClickController extends Controller
{

    public function welcome(){
        return view('welcome');
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

}