<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Location;
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
        $events = Event::with('location')->get();

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
            'happeningDate' => 'required',
            'happeningTime' => 'required',
        ]);

        $strpos = strpos($request->poster, ';');
        $sub = substr($request->poster, 0, $strpos);
        $ext = explode('/', $sub)[1];
        $fileName = time() . Str::random(10) . "." . $ext;

        $path = 'posters/' . $fileName;

        $img = Image::make($request->poster)->resize(200, 200)->encode($ext);

        Storage::disk('s3')->put($path, (string)$img, 'public');

        $url = Storage::disk('s3')->url($path);

        $event = new Event();
        $event->name = $request->name;
        $event->hashTag = $request->hashTag;
        $event->poster = $url;
        $event->location = $request->location;
        $event->venue = $request->venue;
        $event->duration = $request->duration;
        $event->happening_date = $request->happeningDate;
        $event->happening_time = $request->happeningTime;
        $event->save();

        return $this->successResponse([
            'message' => 'Event saved successfully'
        ]);

    }
}
