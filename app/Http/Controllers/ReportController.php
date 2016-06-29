<?php

namespace App\Http\Controllers;

use App\Click;
use Carbon\Carbon;
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

    public function perHour(Request $request)
    {
        $start = $request->get('start_hour');
        $end = $request->get('end_hour');
        $start_date = $request->get('start_date');

        $full_start_time = $start_date . ' ' . $start;
        $full_end_time = $start_date . ' ' . $end;

        $start_carbon = Carbon::createFromFormat('d/m/Y H', $full_start_time);
        $end_carbon = Carbon::createFromFormat('d/m/Y H', $full_end_time);

        $male = [];
        $female = [];
        $unknown = [];

        $days = [];

        for ($i=0; $i<7; ++$i) {
            $clicks = Click::whereBetween('fecha', [$start_carbon, $end_carbon])->get();
            $m = 0;
            $f = 0;
            $u = 0;
            foreach ($clicks as $click) {
                $user = $click->user;
                if ($user) {
                    $gender = $user->id_gender;
                    if ($gender==1) ++$m;
                    else ++$f;
                } else ++$u;
            }
            $male[] = $m;
            $female[] = $f;
            $unknown[] = $u;

            $days[] = $this->toDayName($start_carbon->dayOfWeek);

            $start_carbon->addDay();
            $end_carbon->addDay();
        }

        $data['male'] = $male;
        $data['female'] = $female;
        $data['unknown'] = $unknown;
        $data['days'] = $days;
        return $data;
    }

    public function perPages(Request $request)
    {
        $year = $request->get('anual');
        $month = $request->get('meses');

        $start_carbon = Carbon::create($year, $month, 1);
        $end_carbon = Carbon::create($year, $month+1, 1);

        $dom = [];
        $quantity = [];

        $pages = [];

        $clicks = Click::whereBetween('fecha', [$start_carbon, $end_carbon->subDay()])
            ->where('referencia', 'not like', '%cliserv%')->get(['referencia']);
        //$pages = $clicks;
        //dd($pages);

        foreach ($clicks as $click) {
            $pagina = $click->referencia;
            $pagina = str_replace("http://", "", $pagina);
            $pagina = str_replace("https://", "", $pagina);
            $pos = strpos($pagina, "/");
            if($pos !== false)
                $pagina = substr($pagina, 0, $pos);
            array_push($pages, $pagina);
            //var_dump($pagina);
        }

        for ($i=0; $i<sizeof($pages); ++$i)
        {
            $j = $this->encontrado($pages[$i], $dom);
            if($j != -1)
                $quantity[$j]++;
            else{
                $dom[] = $pages[$i];
                $quantity[]=1;
            }
        }

        //var_dump($dom);
        //var_dump($quantity);

        //dd("gbfgrfb");

        $data['dom'] = $dom;
        $data['quantity'] = $quantity;
        //dd($data);
        return $data;
    }

    public function encontrado($page, $dom){
        for ($i=0; $i<sizeof($dom); ++$i)
            if($dom[$i] == $page)
                return $i;
        return -1;
    }

    public function toDayName($day) {
        $dayName = "";
        switch ($day) {
            case 0: $dayName = 'Domingo'; break;
            case 1: $dayName = 'Lunes'; break;
            case 2: $dayName = 'Martes'; break;
            case 3: $dayName = 'Miércoles'; break;
            case 4: $dayName = 'Jueves'; break;
            case 5: $dayName = 'Viernes'; break;
            case 6: $dayName = 'Sábado'; break;
        }

        return $dayName;
    }

    public function bestCategories()
    {
        return view('report_categories');
    }
}

