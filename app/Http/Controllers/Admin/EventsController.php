<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Location;
use App\Models\TicketType;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class EventsController extends Controller
{

    use  ApiResponser;

    public function index()
    {
        return view('admin.events');
    }

    public function getEvents()
    {
        $events = Event::with('location', 'ticket_prices.ticket')->get();

        return $this->showall($events);
    }

    public function addEvent()
    {
        $locations = Location::all();

        return view('admin.add_event', compact('locations'));

    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'hashTag' => 'required',
            'location' => 'required',
            'venue' => 'required',
            'poster' => 'required',
            'duration' => 'required',
            'happening_date' => 'required',
            'happening_time' => 'required',
        ]);

        $urls = $this->uploadImage($request->poster);

        $event = new Event();
        $event->name = $request->name;
        $event->hashTag = $request->hashTag;
        $event->poster = $urls[0];
        $event->large_poster = $urls[1];
        $event->location = $request->location;
        $event->venue = $request->venue;
        $event->duration = $request->duration;
        $event->happening_date = $request->happening_date;
        $event->happening_time = $request->happening_time;
        $event->save();

        return $this->successResponse([
            'message' => 'Event saved successfully'
        ]);

    }

    public function editEvent($id)
    {
        $event = Event::find($id);
        $locations = Location::all();

        return view('admin.edit_event', compact('event', 'locations'));
    }

    public function updateEvent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'hashTag' => 'required',
            'location' => 'required',
            'venue' => 'required',
            'poster_url' => 'required',
            'duration' => 'required',
            'happening_date' => 'required',
            'happening_time' => 'required',
        ]);

        $event = Event::find($id);

        if ($request->poster_url != $event->poster_url) {
            //delete old images
            $posters = [$event->poster, $event->large_poster];
            $this->deletePosters($posters);

            //update image
            $urls = $this->uploadImage($request->poster_url);
            $event->poster = $urls[0];
            $event->large_poster = $urls[1];

        }

        $event->name = $request->name;
        $event->hashTag = $request->hashTag;
        $event->location = $request->location;
        $event->venue = $request->venue;
        $event->duration = $request->duration;
        $event->happening_date = $request->happening_date;
        $event->happening_time = $request->happening_time;
        $event->save();

        return $this->successResponse([
            'message' => 'Event updated successfully'
        ]);


    }

    public function viewEvent($id)
    {
        $event = Event::with('location')->where('id', $id)->first();
        $ticketTypes = TicketType::all();

        return view('admin.view_event', compact('event', 'ticketTypes'));
    }

    public function deleteEvent($id)
    {
        $event = Event::find($id);
        //delete old images
        $posters = [$event->poster, $event->large_poster];
        $this->deletePosters($posters);
        $event->delete();

        return $this->showone($event);

    }

    public function uploadImage($image)
    {
        $strpos = strpos($image, ';');
        $sub = substr($image, 0, $strpos);
        $ext = explode('/', $sub)[1];
        $fileName = time() . Str::random(10) . "." . $ext;


        $smallPath = 'posters/smallImg/' . $fileName;
        $largePath = 'posters/largeImg/' . $fileName;

        $smallImg = Image::make($image)->resize(264, 176)->encode($ext);
        $largeImg = Image::make($image)->resize(1698, 1131)->encode($ext);

        Storage::disk('s3')->put($smallPath, (string)$smallImg, 'public');
        Storage::disk('s3')->put($largePath, (string)$largeImg, 'public');


        $data = [$smallPath, $largePath];

        return $data;
    }

    public function deletePosters($posters)
    {

        foreach ($posters as $poster) {
            Storage::disk('s3')->delete($poster);
        }

    }
}
