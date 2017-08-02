<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PrestashopController extends Controller
{
    public function index(Request $request)
    {
        $customerId = $request->input('id');
        return view('prestashop.index');
    }
}
