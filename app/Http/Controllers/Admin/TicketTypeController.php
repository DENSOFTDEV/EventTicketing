<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketType;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $ticketTypes = TicketType::all();

        return $this->showall($ticketTypes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:ticket_types,name'
        ]);

        $ticketType = new TicketType();
        $ticketType->name = $request->name;
        $ticketType->save();

        return $this->showone($ticketType);

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:ticket_types,name,' . $id
        ]);

        $ticketType = TicketType::find($id);
        $ticketType->name = $request->name;
        $ticketType->save();

        return $this->showone($ticketType);
    }

    public function delete($id)
    {
        $ticketType = TicketType::find($id);
        $ticketType->delete();
        return $this->showone($ticketType);
    }
}
