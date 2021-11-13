<?php

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $guard = 'admin';


    protected $fillable = [
        'name', 'password', 'email'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }


}
