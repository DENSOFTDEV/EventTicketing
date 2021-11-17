<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function staff()
    {
        return view('admin.staff');
    }

    public function users()
    {
        return view('admin.users');
    }
}
