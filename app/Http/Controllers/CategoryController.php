<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryName;
use App\CategoryProduct;
use App\Click;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function bestCategories()
    {
        $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->get();
        $years = []; $years_result = [];

        foreach( $clicks as $item )
        {
            $element = $item->fecha->year;

            if( ! $this->repeated_element($years,$element) )
                $years[] = $element;
        }

        $years_copy = $years;

        //Ordering data from smaller to bigger
        for( $i=0;$i<count($years);$i++ )
        {
            $x = $this->smaller($years_copy);
            $years_result[$i] = $years_copy[$x];
            array_splice($years_copy, $x, 1);
        }

        $years = $years_result;

        return view('report_categories')->with(compact('years'));
    }

    public function bestCategoriesData( $year, $month )
    {
        // GET EXISTENT CATEGORIES
        if( $year == 0 AND $month == 0 )
            $clicks = Click::all();
        else
            $clicks = Click::where(DB::raw('YEAR(fecha)'), $year)->where( DB::raw('MONTH(fecha)'), $month )->get();

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

        $amount_category = []; //Amount of product for every category

        for( $i=0;$i<count($category_arrays);$i++ )
            $amount_category[$i]=0;


        // PROCESS CLICKS, ACCORDING TO PRODUCTS CONTAINED IN EXISTENT CATEGORIES
        if( $year == 0 AND $month == 0 )
            $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->get();
        else
            $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->where(DB::raw('YEAR(fecha)'), $year)->where( DB::raw('MONTH(fecha)'), $month )->get();


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

    public function bigger( $array )
    {
        $pos_mayor=0;
        for( $i=1;$i<count($array);$i++ )
        {
            if( $array[$i]>$array[$pos_mayor] )
                $pos_mayor=$i;
        }

        return $pos_mayor;
    }

    public function smaller($array)
    {
        $pos_menor=0;
        for( $i=1;$i<count($array);$i++ )
        {
            if( $array[$i]<$array[$pos_menor] )
                $pos_menor=$i;
        }
        return $pos_menor;
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

    public function convert_month_name($months)
    {
        $months_name = [];
        foreach( $months as $month )
            $months_name[] = $this->month_name($month);

        return $months_name;
    }

    public function month_name( $month )
    {
        switch($month)
        {
            case 1: return 'Enero';
            case 2: return 'Febrero';
            case 3: return 'Marzo';
            case 4: return 'Abril';
            case 5: return 'Mayo';
            case 6: return 'Junio';
            case 7: return 'Julio';
            case 8: return 'Agosto';
            case 9: return 'Setiembre';
            case 10: return 'Octubre';
            case 11: return 'Noviembre';
            case 12: return 'Diciembre';
        }
    }

    public function months_year( $year )
    {
        $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->where(DB::raw('YEAR(fecha)'), $year)->get();

        $months = []; $months_result = [];

        foreach( $clicks as $item )
        {
            $element = $item->fecha->month;
            if( ! $this->repeated_element($months,$element) )
                $months[] = $element;
        }

        $months_copy = $months;

        //Ordering data from smaller to bigger
        for( $i=0;$i<count($months);$i++ )
        {
            $x = $this->smaller($months_copy);
            $months_result[$i] = $months_copy[$x];
            array_splice($months_copy, $x, 1);
        }

        $months_id = $months_result;
        $months_names = $this->convert_month_name($months_result);

        $data['id'] = $months_id;
        $data['name'] = $months_names;

        return $data;
    }
}