<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketPricing;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TicketPricingController extends Controller
{

    use ApiResponser;

    public function index($id)
    {
        $ticketPrices = TicketPricing::with('ticket')->where('event_id', $id)->get();

        return $this->showall($ticketPrices);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'ticket_id' => 'required',
            'price' => 'required|numeric',
            'reservation_no' => 'required|numeric'
        ]);

        $ticketPrices = TicketPricing::where([
            ['event_id', '=', $id],
            ['ticket_id', '=', $request->ticket_id]
        ])->first();

        if ($ticketPrices !== null) {
            throw ValidationException::withMessages([
                'Ticket Type' => 'This ticket type is already defined'
            ]);
        } else {
            $ticketPricing = new TicketPricing();
            $ticketPricing->event_id = $id;
            $ticketPricing->ticket_id = $request->ticket_id;
            $ticketPricing->price = $request->price;
            $ticketPricing->reservation_no = $request->reservation_no;
            $ticketPricing->save();

            $fullTicketPricing = TicketPricing::with('ticket')->where('id', $ticketPricing->id)->first();

            return $this->showone($fullTicketPricing);
        }

    }

    public function update(Request $request, $event_id, $id)
    {
        $request->validate([
            'ticket_id' => 'required',
            'price' => 'required|numeric',
            'reservation_no' => 'required|numeric'
        ]);

        $ticketPrices = TicketPricing::where([
            ['event_id', '=', $event_id],
            ['ticket_id', '=', $request->ticket_id],
            ['id', '!=', $id],
        ])->first();

        if ($ticketPrices !== null) {
            throw ValidationException::withMessages([
                'Ticket Type' => 'This ticket type is already defined'
            ]);
        } else {
            $ticketPricing = TicketPricing::with('ticket')->find($id);
            $ticketPricing->ticket_id = $request->ticket_id;
            $ticketPricing->price = $request->price;
            $ticketPricing->reservation_no = $request->reservation_no;
            $ticketPricing->save();
            $fullTicketPricing = TicketPricing::with('ticket')->where('id', $ticketPricing->id)->first();
            return $this->showone($fullTicketPricing);
        }
    }

    public function delete($id)
    {

        $ticketPricing = TicketPricing::find($id);
        $ticketPricing->delete();

        return $this->showone($ticketPricing);

    }

}
