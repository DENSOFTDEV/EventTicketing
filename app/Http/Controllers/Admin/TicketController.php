<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use  ApiResponser;

    public function getTickets($id)
    {
        $tickets = Ticket::where('event_id', $id)->with('ticket_pricing.ticket', 'user')->get();

        return $this->showall($tickets);
    }
}
