<?php

namespace App\Http\Controllers;

use App\CategoryName;
use App\CategoryProduct;
use App\Click;
use App\User;
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
        $tomorrow = Carbon::tomorrow();

        $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->whereBetween('fecha',[$today,$tomorrow])->paginate(4);
        if( count($clicks)>0 )
            return view('general')->with(compact('clicks'));
        else
            return view('general');
    }

    public function general_filtered( $inicio,$fin )
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $clicks = Click::whereNotNull('product_id')->where('product_id','!=',0)->whereBetween('fecha',[$today,$tomorrow])->get();
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

        if( count($category)>1 ) //If = 0 there is no data
        {
            $image_test = Picture::where('id_product',$product[0])->first();
            $image = $image_test->id_image;
            return view('tendencia')->with(compact('product','category','image'));
        }else
            return view('tendencia');
    }

    public function tendencia_users()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $product = $this->bestProduct();

        // When product_id is ="some text", that is like product_id = 0

        if( count($product) > 1 ) {
            $clicks = Click::where('url','<>','')->whereBetween('fecha',[$today,$tomorrow])->where('url','like', '%'.$product[2].'%')->get();

            $users = [];
            $users_clicks = [];
            foreach ($clicks as $click)
                if (!$this->repeated_element($users, $click->user_id))
                    $users [] = $click->user_id;

            foreach ($users as $user) {
                $users_clicks[] = $clicks->where('user_id', $user)->count();
            }

            $users_clone = $users; $users_clicks_clone = $users_clicks;
            $users_result = [];    $users_clicks_result = [];

            for ($i = 0; $i < count($users_clicks); $i++) {
                $x = $this->bigger($users_clicks_clone);
                $users_clicks_result[$i] = $users_clicks_clone[$x];
                $users_result[$i] = $users_clone[$x];

                array_splice($users_clicks_clone, $x, 1);
                array_splice($users_clone, $x, 1);
            }

            $name = []; $location = []; $gender = []; $email = [];

            for ($i = 0; $i < count($users_result); $i++) {

                $click = Click::where('user_id', $users_result[$i])->first();
                $name     [$i] = $click->user_name;
                $location [$i] = $click->country . ' - ' . $click->city;
                if( $users_result[$i] == 0 )
                {
                    $gender   [$i] = 'Desconocido';
                    $email    [$i] = '';
                }
                else
                {
                    $gender   [$i] = ($click->user->id_gender ==1)? 'Hombre':'Mujer';
                    $email    [$i] = $click->user->email;
                }
            }

            if(  count( $users_clicks_result )<11 )
            {
                $data['error']    = false;
                $data['name']     = $name;
                $data['location'] = $location;
                $data['gender']   = $gender;
                $data['email']    = $email;
                $data['visits']   = $users_clicks_result;
            }else
            {
                $names = []; $locations = []; $genders = []; $emails = []; $visits = [];
                for( $i = 0; $i<10;$i++)
                {
                    $names    [] = $name[$i];
                    $locations[] = $location[$i];
                    $genders  [] = $gender[$i];
                    $emails   [] = $email[$i];
                    $visits   [] = $users_clicks_result[$i];
                }
                $data['error']    = false;
                $data['name']     = $names;
                $data['location'] = $locations;
                $data['gender']   = $genders;
                $data['email']    = $emails;
                $data['visits']   = $visits;
            }
        }
        else
            $data['error'] = true;
        return $data;
    }

    public function tendencia_categories()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $category = $this->bestCategory();

        if( count($category) > 1 ) {
            $clicks = Click::where('url','<>','')->whereBetween('fecha',[$today,$tomorrow])->where('url','like', '%'.$category[2].'%')->get();

            $users = [];
            $users_clicks = [];
            foreach ($clicks as $click)
                if (!$this->repeated_element($users, $click->user_id))
                    $users [] = $click->user_id;

            foreach ($users as $user) {
                $users_clicks[] = $clicks->where('user_id', $user)->count();
            }

            $users_clone = $users; $users_clicks_clone = $users_clicks;
            $users_result = [];    $users_clicks_result = [];

            for ($i = 0; $i < count($users_clicks); $i++) {
                $x = $this->bigger($users_clicks_clone);
                $users_clicks_result[$i] = $users_clicks_clone[$x];
                $users_result[$i] = $users_clone[$x];

                array_splice($users_clicks_clone, $x, 1);
                array_splice($users_clone, $x, 1);
            }

            $name = []; $location = []; $gender = []; $email = [];

            for ($i = 0; $i < count($users_result); $i++) {

                $click = Click::where('user_id', $users_result[$i])->first();
                $name     [$i] = $click->user_name;
                $location [$i] = $click->country . ' - ' . $click->city;
                if( $users_result[$i] == 0 )
                {
                    $gender   [$i] = 'Desconocido';
                    $email    [$i] = '';
                }
                else
                {
                    $gender   [$i] = ($click->user->id_gender ==1)? 'Hombre':'Mujer';
                    $email    [$i] = $click->user->email;
                }
            }

            if(  count( $users_clicks_result )<11 )
            {
                $data['error']    = false;
                $data['name']     = $name;
                $data['location'] = $location;
                $data['gender']   = $gender;
                $data['email']    = $email;
                $data['visits']   = $users_clicks_result;
            }else
            {
                $names = []; $locations = []; $genders = []; $emails = []; $visits = [];
                for( $i = 0; $i<10;$i++)
                {
                    $names    [] = $name[$i];
                    $locations[] = $location[$i];
                    $genders  [] = $gender[$i];
                    $emails   [] = $email[$i];
                    $visits   [] = $users_clicks_result[$i];
                }
                $data['error']    = false;
                $data['name']     = $names;
                $data['location'] = $locations;
                $data['gender']   = $genders;
                $data['email']    = $emails;
                $data['visits']   = $visits;
            }
        }
        else
            $data['error'] = true;
        return $data;

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
        $today  = Carbon::today();
        $tomorrow   = Carbon::tomorrow();

        $clicks = Click::where('url','<>','')->whereBetween('fecha',[$today,$tomorrow])->get();
        $products = Product::where('id_lang',1)->get();

        $product_link_rewrite = [];
        foreach ($products as $product) {
            $product_link_rewrite [] = $product->link_rewrite;
        }

        if( count($clicks) != 0 )
        {
            $products_quantity = [];

            foreach( $product_link_rewrite as $link )
                $products_quantity[] = Click::where('url','<>','')->whereBetween('fecha',[$today,$tomorrow])->where('url','like','%'.$link.'%')->count();

            $products_quantity_copy = $products_quantity; $product_link_rewrite_copy = $product_link_rewrite;
            $result_products = [];   $result_quantity = [];

            // Ordering data from bigger to smaller
            for( $i=0;$i<count($products_quantity);$i++ )
            {
                $x = $this->bigger($products_quantity_copy);
                $result_quantity[$i] = $products_quantity_copy[$x];
                $result_products[$i] = $product_link_rewrite_copy[$x];

                array_splice($products_quantity_copy, $x, 1);
                array_splice($product_link_rewrite_copy, $x, 1);
            }

            $product_test = Product::where('link_rewrite',$result_products[0])->where('id_lang',1)->first();

            // The best selling product

            $produt_[0] = $product_test->id_product;
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
        $today  = Carbon::today();
        $tomorrow  = Carbon::tomorrow();
        $clicks = Click::where('url','<>','')->whereBetween('fecha',[$today,$tomorrow])->get();

        if( count($clicks) !=0 )
        {
            $category_arrays = []; // Available categories according to clicks data(product_id)

            foreach( $clicks as $click )
            {
                $url = $click->url;
                $string = str_ireplace('http://cliserv.esy.es/es/','',$url);
                if ( is_numeric( substr($string,0,1) ) AND  substr($string,1,1)=='-' )
                    if (!$this->repeated_element($category_arrays, substr($string,0,1)))
                        $category_arrays[] = substr($string,0,1);
            }

            $category_names = [];
            foreach ($category_arrays as $category_array) {
                $category = CategoryName::where('id_category',$category_array)->where('id_lang',1)->first();
                $category_names[] = $category->link_rewrite;
            }

            $category_quantity =[];
            foreach ($category_names as $category_name) {
                $category_quantity[] = Click::where('url','<>','')->whereBetween('fecha',[$today,$tomorrow])->where('url','like','%'.$category_name.'%')->count();
            }

            $category_names_copy = $category_names; $category_quantity_copy = $category_quantity;
            $result_categories = [];   $result_quantity = [];

            for( $i=0;$i<count($category_quantity);$i++ )
            {
                $x = $this->bigger($category_quantity_copy);
                $result_quantity[$i]   = $category_quantity_copy[$x];
                $result_categories[$i] = $category_names_copy[$x];

                array_splice($category_quantity_copy, $x, 1);
                array_splice($category_names_copy, $x, 1);
            }

            $category_test = CategoryName::where('link_rewrite',$result_categories[0])->where('id_lang',1)->first();

            $category_[0] = $category_test->id_category;
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