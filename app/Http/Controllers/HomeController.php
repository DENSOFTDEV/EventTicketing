<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    use ApiResponser;

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


    public function tickets()
    {
        return view('account.tickets');
    }


    public function getTickets()
    {
        $events = Ticket::where('user_id', Auth::user()->id)->with('event', 'ticket_pricing.ticket')->orderBy('event_id','ASC')->get();

        return $this->showall($events);
    }


    public function payments()
    {
        return view('account.payments');
    }

    public function account()
    {
        return view('account.payments');
    }
}
