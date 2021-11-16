<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Location;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Dennis Githinji',
            'email' => 'wakahiad@gmail.com',
            'password' => Hash::make('password')
        ]);

        $locations = ['kiambu', 'kisii', 'mombasa', 'kisumu', 'nyeri'];

        foreach ($locations as $location) {
            $loc = new Location();
            $loc->name = $location;
            $loc->save();
        }

        $ticketTypes = ['Regular', 'Vip', 'VVip'];

        foreach ($ticketTypes as $type) {
            $ticketType = new TicketType();
            $ticketType->name = $type;
            $ticketType->save();
        }
    }
}
