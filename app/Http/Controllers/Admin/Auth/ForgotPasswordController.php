<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    public function broker()
    {
        return Password::broker('admins');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }
}
