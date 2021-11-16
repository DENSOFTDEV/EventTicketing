<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Ticket;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Jackiedo\DotenvEditor\DotenvEditor;

class SettingsController extends Controller
{

    use ApiResponser;

    protected $editor;

    /**
     * SettingsController constructor.
     * @param $editor
     */
    public function __construct(DotenvEditor $editor)
    {
        $this->editor = $editor;
    }


    public function index()
    {

        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3|max:20',
            'logo' => 'required',
            'maxReservations' => 'required|numeric'
        ]);

        $strpos = strpos($request->logo, ';');
        $sub = substr($request->logo, 0, $strpos);
        $ext = explode('/', $sub)[1];
        $fileName = time() . Str::random(10) . "." . $ext;

        $path = 'logo/' . $fileName;

        $img = Image::make($request->logo)->resize(200, 200)->encode($ext);

        Storage::disk('s3')->put($path, (string)$img, 'public');

        $url = Storage::disk('s3')->url($path);


        $this->editor->setKeys([
            'APP_NAME' => $request->name,
            'App_Logo' => $url,
            'Max_Reservations' => $request->maxReservations
        ]);


        $this->editor->save();


        return $path;

    }

    public function getTicketTypes()
    {
        $ticketTypes = Setting::where('name', 'ticketTypes')->first();

        return $this->successResponse([
            'ticketTypes' => $ticketTypes->value
        ]);
    }

    public function addTicketTypes(Request $request)
    {

        $request->validate([
            'type' => 'required'
        ]);

        $ticketTypes = Setting::where('name', 'ticketTypes')->first();

        if ($ticketTypes === null) {
            $ticketTypes = new  Setting();
            $ticketTypes->name = 'ticketTypes';
            $ticketTypes->value = [$request->type];
            $ticketTypes->save();
        } else {
            $existingTypes = $ticketTypes->value;
            if (in_array($request->type, $existingTypes)) {
                return $this->errorResponse('Ticket type exists');
            } else {
                array_push($existingTypes, $request->type);
                $ticketTypes->value = $existingTypes;
                $ticketTypes->save();
            }
        }

        return $this->successResponse([
            'message' => 'Ticket type saved successfully',
            'ticketType' => $request->type
        ]);

    }

    public function deleteTicket(Request $request)
    {
        $ticketTypes = Setting::where('name', 'ticketTypes')->first();



    }
}
