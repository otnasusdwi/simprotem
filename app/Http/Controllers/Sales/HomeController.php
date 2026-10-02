<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('sales.salesHome');
    }

    // public function adminHome()
    // {
    //     return view('adminHome');
    // }
}
