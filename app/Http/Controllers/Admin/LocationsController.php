<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $locations = Location::all();

        return $this->showall($locations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:locations,name'
        ]);

        $location = new Location();
        $location->name = $request->name;
        $location->save();

        return $this->showone($location);

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:locations,name,' . $id
        ]);

        $location = Location::find($id);
        $location->name = $request->name;
        $location->save();

        return $this->showone($location);
    }

    public function delete($id)
    {
        $location = Location::find($id);
        $location->delete();
        return $this->showone($location);
    }
}
