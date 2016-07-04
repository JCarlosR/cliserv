<?php

namespace App\Http\Controllers;

use App\CategoryName;
use App\CategoryProduct;
use App\Click;
use Illuminate\Http\Request;
use App\Picture;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClickController extends Controller
{

    public function welcome(){
        return view('welcome');
    }

    public function general()
    {
        $today = Carbon::today();
        $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->where('fecha','>=',$today)->paginate(4);
        if( count($clicks)>0 )
            return view('general')->with(compact('clicks'));
        else
            return view('general');
    }

    public function general_filtered( $inicio,$fin )
    {

        $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->whereBetween('fecha', array($inicio, $fin))->get();
        $users    = [];
        $products = [];
        $devices  = [];
        $places   = [];
        $i=0;
        foreach( $clicks as $click )
        {
            $users[$i]    = $click->user_name;
            $products[$i] = $click->product->name;
            $devices[$i]  = $click->dispositivo;
            $places[$i]   = $click->country.'-'.$click->city;
            $i++;
        }

        $data['users']    = $users;
        $data['products'] = $products;
        $data['devices']  = $devices;
        $data['places']   = $places;

        return $data;
    }

    public function tendencia()
    {
        $category  = $this->bestCategory();
        $product = $this->bestProduct();

        if( count($category)>1 )
        {
            $image_test = Picture::where('id_product',$product[0])->first();
            $image = $image_test->id_image;
            return view('tendencia')->with(compact('product','category','image'));
        }else
            return view('tendencia');
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
        $clicks = Click::where('referencia', 'not like', '%cliserv%')->get();
        $years = []; $years_result = [];

        foreach( $clicks as $click )
        {
            $element = $click->fecha->year;

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


        return view('pages')->with(compact('years'));
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

    public function traffic()
    {
        return view('traffic');
    }

    public function months_year( $year )
    {
        $clicks = $clicks = Click::where('referencia', 'not like', '%cliserv%')->where(DB::raw('YEAR(fecha)'), $year)->get();

        $months = []; $months_result = [];

        foreach( $clicks as $click )
        {
            $element = $click->fecha->month;
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

    public function bestProduct()
    {
        $yesterday  = Carbon::yesterday();
        $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->where('fecha','>',$yesterday)->get();

        if( count($clicks) != 0 )
        {
            $products_arrays = [];

            foreach( $clicks as $click )
            {
                $element = $click->product_id;
                if ( !$this->repeated_element( $products_arrays,$element) )
                    $products_arrays[] = $element;
            }

            $amount_product = []; // Amount of product for every category

            for( $i=0;$i<count($products_arrays);$i++ )
                $amount_product[$i]=0;

            foreach( $clicks as $click )
            {
                $element = $click->product_id;
                for( $i=0;$i<count($products_arrays);$i++ )
                    if( $products_arrays[$i] == $element )
                        ++$amount_product[$i];
            }

            $copy_amount_product = $amount_product; $copy_product_arrays = $products_arrays;
            $result_products = [];   $result_amounts = [];

            // Ordering data from bigger to smaller
            for( $i=0;$i<count($amount_product);$i++ )
            {
                $x = $this->bigger($copy_amount_product);
                $result_amounts[$i] = $copy_amount_product[$x];
                $result_products[$i] = $copy_product_arrays[$x];

                array_splice($copy_amount_product, $x, 1);
                array_splice($copy_product_arrays, $x, 1);
            }

            $product_test = Product::where('id_product',$result_products[0])->where('id_lang',1)->first();

            // The best selling product

            $produt_[0] = $result_products[0];
            $produt_[1] = $product_test->name;
            $produt_[2] = $product_test->link_rewrite;
            return $produt_;
        }
        else
        {
            $messsage[0] = "No hay datos ingresados";
            return $messsage;
        }
    }

    public function bestCategory()
    {
        $yesterday  = Carbon::yesterday();
        $clicks = Click::where('fecha','>',$yesterday)->get();


        if( count($clicks) !=0 )
        {
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

            $amount_category = []; // Amount of product for every category

            for( $i=0;$i<count($category_arrays);$i++ )
                $amount_category[$i]=0;

            // PROCESS CLICKS, ACCORDING TO PRODUCTS CONTAINED IN EXISTENT CATEGORIES
            $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->where('fecha','>',$yesterday)->get();

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

            // $amount_category = array that contains amount of products inside a category, $category_arrays = array of existent categories
            // Ordering data from bigger to smaller
            for( $i=0;$i<count($amount_category);$i++ )
            {
                $x = $this->bigger($copy_amount_category);
                $result_amounts[$i] = $copy_amount_category[$x];
                $result_categories[$i] = $copy_category_arrays[$x];

                array_splice($copy_amount_category, $x, 1);
                array_splice($copy_category_arrays, $x, 1);
            }

            $category_test = CategoryName::where('id_category',$result_categories[0])->first();
            // The best selling category

            $category_[0] = $result_categories[0];
            $category_[1] = $category_test->name;
            $category_[2] = $category_test->link_rewrite ;
            return $category_;
        }
        else
        {
            $message[0] = "No hay datos ingresados";
            return $message;
        }
    }
}