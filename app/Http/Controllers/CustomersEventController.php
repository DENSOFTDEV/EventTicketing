<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketPricing;
use App\Models\TicketType;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomersEventController extends Controller
{

    use ApiResponser;

    public function getEvents()
    {
        $events = Event::with('location', 'ticket_prices.ticket')->get();

        return $this->showall($events);

    }

    public function showEvent($id)
    {
        $event = Event::where('id', $id)->with('location', 'ticket_prices.ticket')->first();

        return view('event', compact('event'));
    }

    public function reserveTicket(Request $request, $id)
    {
        $request->validate([
            'ticket_id' => 'required',
            'reservation_no' => 'required'
        ]);

        $user = Auth::user();


        $remainingTickets = $this->checkMaxReservations($id);

        if ($remainingTickets < $request->reservation_no) {
            return $this->errorResponse('You can only reserve ' . ($remainingTickets) . ' tickets');
        }


        $tickets = Ticket::where([
            ['event_id', '=', $id],
            ['user_id', '=', $user->id]
        ])->get();

        $existingTicketsCount = count($tickets);

        if ($existingTicketsCount >= 5) {

            return $this->errorResponse('You have exhausted your maximum reservations');
        } else {
            if (($existingTicketsCount + $request->reservation_no) > 5) {

                return $this->errorResponse('You can only reserve ' . (5 - $existingTicketsCount) . ' tickets');
            } else {

                $ticket_type = TicketPricing::find($request->ticket_id);

                for ($i = 0; $i < $request->reservation_no; $i++) {
                    $ticket = new Ticket();
                    $ticket->event_id = $id;
                    $ticket->user_id = $user->id;
                    $ticket->type = $request->ticket_id;
                    $ticket->code = Str::random('10');
                    $ticket->price = $ticket_type->price;
                    $ticket->save();
                }

                return $this->successResponse([
                    'message' => 'Tickets reserved successfully'
                ]);
            }
        }

    }

    public function checkMaxReservations($event_id)
    {

        $ticketPricing = TicketPricing::where('event_id', $event_id)->get()->pluck('reservation_no')->toArray();

        $expectedReservations = array_sum($ticketPricing);

        $reservedTickets = Ticket::where('event_id', $event_id)->get();

        $totalReservedTickets = count($reservedTickets);

        if ($expectedReservations > $totalReservedTickets) {
            return ($expectedReservations - $totalReservedTickets);
        } else {
            return $this->errorResponse('No Tickets Available');
        }

    }
}
