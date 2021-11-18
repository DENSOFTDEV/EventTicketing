<?php

namespace App\Http\Controllers;

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
        return view('account.home');
    }


    public function tickets(){
        return view('account.tickets');
    }


    public function payments(){
        return view('account.payments');
    }

    public function account(){
        return view('account.payments');
    }
}
