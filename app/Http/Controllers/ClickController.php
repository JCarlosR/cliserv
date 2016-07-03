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
        
        $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->where('fecha','>=',$today)->get();

        dd($clicks);


        $category_arrays = []; // Available categories according to clicks data(product_id)

        foreach( $clicks as $click )
        {
            $categories = CategoryProduct::where('id_product',$click->product_id)->get();
            foreach ( $categories as $category )
            {
                if( $category->id_category != 2 ) {
                    $element = $category->id_category;
                    if (!$this->repeated_element($category_arrays, $element))
                        $category_arrays[] = $element;
                }
            }
        }

        $amount_category = []; //Amount of product for every category

        for( $i=0;$i<count($category_arrays);$i++ )
            $amount_category[$i]=0;

        foreach( $clicks as $click )
        {
            $categories = CategoryProduct::where('id_product',$click->product_id)->get();
            foreach ( $categories as $category )
            {
                $element = $category->id_category;

                for( $i=0;$i<count($category_arrays);$i++ )
                    if( $category_arrays[$i] == $element )
                        ++$amount_category[$i];
            }
        }

        $copy_amount_category = $amount_category; $copy_category_arrays = $category_arrays;
        $result_categories = [];   $result_amounts = [];

        //Ordering data from bigger to smaller
        for( $i=0;$i<count($amount_category);$i++ )
        {
            $x = $this->bigger($copy_amount_category);
            $result_amounts[$i] = $copy_amount_category[$x];
            $result_categories[$i] = $copy_category_arrays[$x];

            array_splice($copy_amount_category, $x, 1);
            array_splice($copy_category_arrays, $x, 1);
        }

        $category_name_ordered = [];

        for( $i=0; $i<count($result_categories);$i++ )
        {
            $category_x = CategoryName::where('id_category',$result_categories[$i])->first();
            $category_name_ordered[] = $category_x->name;
        }

        $category_name = []; $category_amount =[];

        // Getting the x=5 bigger elements

        if(  count($result_amounts )<5 )
        {
            $data['name']     = $category_name_ordered;
            $data['quantity'] = $result_amounts;
        }else
        {
            for( $i = 0; $i<5;$i++)
            {
                $category_name[] = $category_name_ordered[$i];
                $category_amount[] = $result_amounts[$i];
            }
            $data['name']     = $category_name;
            $data['quantity'] = $category_amount;
        }
        return $data;
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