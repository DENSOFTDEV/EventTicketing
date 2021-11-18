<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    use ApiResponser;

    public function staff()
    {
        return view('admin.staff');
    }

    public function getStaff()
    {

        $admins = Admin::all();

        return $this->showall($admins);
    }

    public function users()
    {
        return view('admin.users');
    }

    public function getUsers()
    {
        $users = User::all();

        return $this->showall($users);
    }
}
