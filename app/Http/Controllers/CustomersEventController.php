<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketPricing;
use App\Models\TicketType;
use App\Notifications\TicketReservation;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomersEventController extends Controller
{

    use ApiResponser;

    public function getEvents()
    {
        $events = Event::with('location', 'ticket_prices.ticket')->get();

        //filter past dates
        $events = $events->filter(function ($event) {
            $full_date_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "{$event->happening_date} {$event->happening_time}");
            if ($full_date_time->isFuture()) {
                return $event;
            }
        });

        $events->all();

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


        $remainingTickets = $this->checkMaxReservations($id, $request->ticket_id);


        $ticket_pricing = TicketPricing::with('ticket')->where('id', $request->ticket_id)->first();

        if ($remainingTickets == 0) {
            return $this->errorResponse('No tickets remaining for ' . $ticket_pricing->ticket->name . ' ticket');
        }


        if ($remainingTickets < $request->reservation_no) {
            return $this->errorResponse('Only ' . ($remainingTickets) . ' ticket(s) left out for ' . $ticket_pricing->ticket->name . ' ticket');
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

                return $this->errorResponse('You can only reserve ' . (5 - $existingTicketsCount) . ' ticket(s)');
            } else {

                $ticket_type = TicketPricing::find($request->ticket_id);

                $tickets = collect();

                for ($i = 0; $i < $request->reservation_no; $i++) {
                    $ticket = new Ticket();
                    $ticket->event_id = $id;
                    $ticket->user_id = $user->id;
                    $ticket->type = $request->ticket_id;
                    $ticket->code = Str::random('10');
                    $ticket->price = $ticket_type->price;
                    $ticket->save();

                    $fullTicket = Ticket::where('id', $ticket->id)->with('ticket_pricing.ticket')->first();

                    $tickets->add($fullTicket);

                }

                $user->notify(new TicketReservation($user, $tickets, Event::find($id)));

                return $this->successResponse([
                    'message' => 'Tickets reserved successfully'
                ]);
            }
        }

    }

    public function checkMaxReservations($event_id, $ticket_pricing_id)
    {

        $ticketPricing = TicketPricing::where('id', $ticket_pricing_id)->first();

        $expectedReservations = $ticketPricing->reservation_no;

        $reservedTickets = Ticket::where([
            ['event_id', '=', $event_id],
            ['type', '=', $ticket_pricing_id],
        ])->get();

        $totalReservedTickets = count($reservedTickets);

        return ($expectedReservations - $totalReservedTickets);

    }
}
