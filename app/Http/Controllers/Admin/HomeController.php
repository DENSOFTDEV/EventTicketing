<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $users = count(User::all());

        $events = count(Event::all());

        $tickets = count(Ticket::all());

        $staff = count(Admin::all());

        return view('admin.home', compact('users', 'events', 'tickets', 'staff'));
    }
}
