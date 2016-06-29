<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends Controller
{
    public function bestCategories()
    {
        $categories = Category::all();
        dd($categories);


        return view('report_categories');
    }

    public function bigger($array)
    {
        $pos_mayor=0;
        $mayor = $array[0];
        for( $i=1;$i<count($array);$i++ )
        {
            if( $array[$i]>$mayor )
                $pos_mayor=$i;
        }

        return $pos_mayor;
    }

    public function smaller($array)
    {
        $pos_menor=0;
        $menor = $array[0];
        for( $i=1;$i<count($array);$i++ )
        {
            if( $array[$i]<$menor )
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
            case 1:
                return 'Enero';
            case 2:
                return 'Febrero';
            case 3:
                return 'Marzo';
            case 4:
                return 'Abril';
            case 5:
                return 'Mayo';
            case 6:
                return 'Junio';
            case 7:
                return 'Julio';
            case 8:
                return 'Agosto';
            case 9:
                return 'Setiembre';
            case 10:
                return 'Octubre';
            case 11:
                return 'Noviembre';
            case 12:
                return 'Diciembre';
        }
    }

    public function months_year( $year )
    {
        $items = Item::where( DB::raw('YEAR(created_at)'), $year )->get();
        $months = []; $months_result = [];

        foreach( $items as $item )
        {
            $element = $item->created_at->month;
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

    public function bar()
    {
        $items = Item::all();
        $years = []; $years_result = [];

        foreach( $items as $item )
        {
            $element = $item->created_at->year;

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

        return view('reports.barChart')->with(compact('years'));
    }

    public function data_bar( $year, $month )
    {

        $products = Product::all();
        $items     = []; $products_ = []; $i=0;

        if( $year == 0 AND $month == 0 )
        {
            foreach( $products as $product )
            {
                $count = Item::where('product_id',$product->id)->count();
                $products_[$i] = $product->name;
                $items[$i] = $count;
                $i++;
            }
        }
        else
        {
            foreach( $products as $product )
            {
                $count = Item::where('product_id',$product->id)->where( DB::raw('YEAR(created_at)'), $year )->where( DB::raw('MONTH(created_at)'), $month )->count();
                $products_[$i] = $product->name;
                $items[$i] = $count;
                $i++;
            }
        }

        $copy_items = $items; $copy_products = $products_;
        $result_items = [];   $result_products = [];

        //Ordering data from bigger to smaller
        for( $i=0;$i<count($items);$i++ )
        {
            $x = $this->bigger($copy_items);
            $result_items[$i] = $copy_items[$x];
            $result_products[$i] = $copy_products[$x];

            array_splice($copy_items, $x, 1);
            array_splice($copy_products, $x, 1);
        }

        $products_name = []; $products_count =[];

        // Getting the x=7 bigger elements
        for( $i = 0; $i<5;$i++)
        {
            $products_name[] = $result_products[$i];
            $products_count[] = $result_items[$i];
        }

        $data['name']     = $products_name;
        $data['quantity'] = $products_count;

        return $data;
    }
}
