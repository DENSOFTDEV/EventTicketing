<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;


    protected $appends = ['poster_url', 'large_poster_url'];

    protected $hidden = ['poster', 'large_poster'];


    public function location()
    {
        return $this->belongsTo(Location::class, 'location');
    }

    public function ticket_prices()
    {
        return $this->hasMany(TicketPricing::class, 'event_id');
    }


    public function getPosterUrlAttribute()
    {

        return Storage::disk('s3')->url($this->poster);

    }

    public function getLargePosterUrlAttribute()
    {

        return Storage::disk('s3')->url($this->large_poster);

    }


}
