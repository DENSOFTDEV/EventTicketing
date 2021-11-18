<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\HomeController as HomeControllerAlias;
use App\Http\Controllers\Admin\LocationsController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TicketPricingController;
use App\Http\Controllers\Admin\TicketTypeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\CustomersEventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/contact', function () {
    return view('contact-us');
})->name('contact-us');

Route::get('/events', [CustomersEventController::class, 'getEvents']);
Route::get('/event/{id}', [CustomersEventController::class, 'showEvent'])->name('event-details');

Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/tickets', [HomeController::class, 'tickets'])->name('tickets');
    Route::get('/get-tickets', [HomeController::class, 'getTickets']);
    Route::get('/payments', [HomeController::class, 'payments'])->name('payments');
    Route::get('/account', [HomeController::class, 'account'])->name('account');

    Route::post('reserve-ticket/{id}', [CustomersEventController::class, 'reserveTicket']);
});


//admin routes

Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'createAdmin'])->name('register');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    //Forgot Password Routes
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    //Reset Password Routes
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [HomeControllerAlias::class, 'index'])->name('home');
        //users
        Route::get('/users/staff', [UsersController::class, 'staff'])->name('staff');
        Route::get('/users/customers', [UsersController::class, 'users'])->name('users');
        Route::get('/get-staff', [UsersController::class, 'getStaff']);
        Route::get('/get-users', [UsersController::class, 'getUsers']);
        //events
        Route::get('/events', [EventsController::class, 'index'])->name('events');
        Route::get('/get-events', [EventsController::class, 'getEvents']);
        Route::get('/add-event', [EventsController::class, 'addEvent']);
        Route::post('/store-event', [EventsController::class, 'storeEvent']);
        Route::get('/edit-event/{id}', [EventsController::class, 'editEvent']);
        Route::post('/update-event/{id}', [EventsController::class, 'updateEvent']);
        Route::get('/view-event/{id}', [EventsController::class, 'viewEvent']);
        Route::get('/delete-event/{id}', [EventsController::class, 'deleteEvent']);

        //tickets
        Route::get('/get-tickets/{id}', [TicketController::class, 'getTickets']);

        //ticket pricing
        Route::get('/ticket-prices/{id}', [TicketPricingController::class, 'index']);
        Route::post('/store-ticket-price/{id}', [TicketPricingController::class, 'store']);
        Route::post('/update-ticket-price/{event_id}/{id}', [TicketPricingController::class, 'update']);
        Route::get('/delete-ticket-price/{id}', [TicketPricingController::class, 'delete']);

        //general settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/update-settings', [SettingsController::class, 'updateSettings']);
        //ticket types
        Route::get('/get-ticket-types', [TicketTypeController::class, 'index']);
        Route::post('/add-ticket-type', [TicketTypeController::class, 'store']);
        Route::post('/update-ticket-type/{id}', [TicketTypeController::class, 'update']);
        Route::get('/delete-ticket-type/{id}', [TicketTypeController::class, 'delete']);
        //locations
        Route::get('/get-locations', [LocationsController::class, 'index']);
        Route::post('/add-location', [LocationsController::class, 'store']);
        Route::post('/update-location/{id}', [LocationsController::class, 'update']);
        Route::get('/delete-location/{id}', [LocationsController::class, 'delete']);

        //payments
        Route::get('/payments', [PaymentsController::class, 'index'])->name('payments');
    });
});

