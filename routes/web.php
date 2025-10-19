<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\BookAreaController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Frontend\FrontEndRoomController;
use App\Http\Controllers\Frontend\BookingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/profile/store', [UserController::class, 'UserStore'])->name('profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/change/password/store', [UserController::class, 'ChangePasswordStore'])->name('password.change.store');
});

require __DIR__.'/auth.php';

//Admin group middleware
Route::middleware(['auth', 'roles:admin'])->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

//Admin group middleware
Route::middleware(['auth', 'roles:admin'])->group(function() {
    //Using grouping method to handle the controller and routes
    Route::controller(TeamController::class)->group(function() {
        Route::get('/all/team', 'AllTeam')->name('all.team');
        Route::get('/add/team', 'AddTeam')->name('add.team');
        Route::post('/team/store', 'StoreTeam')->name('team.store');
        Route::get('/edit/team/{id}', 'EditTeam')->name('edit.team');
        Route::post('/team/update/store', 'StoreUpdatedTeam')->name('team.update.store');
        Route::get('/delete/team/{id}', 'DeleteTeam')->name('delete.team');
    });
});

//Admin group middleware
Route::middleware(['auth', 'roles:admin'])->group(function() {
    //Using grouping method to handle the controller and routes
    Route::controller(BookAreaController::class)->group(function() {
        Route::get('/all/bookarea', 'AllBookArea')->name('all.book.area');
        Route::get('/add/bookarea', 'AddBookArea')->name('add.book.area');
        Route::post('/bookarea/store', 'StoreBookarea')->name('book.area.store');
        Route::get('/edit/bookarea/{id}', 'EditBookarea')->name('edit.book.area');
        Route::post('/bookarea/update/store', 'StoreUpdatedBookarea')->name('bookarea.update.store');
        Route::get('/delete/bookarea/{id}', 'DeleteBookarea')->name('delete.book.area');
    });
});

//Admin group middleware
Route::middleware(['auth', 'roles:admin'])->group(function() {
    //Using grouping method to handle the controller and routes
    Route::controller(RoomTypeController::class)->group(function() {
        Route::get('/all/roomtype', 'AllRoomType')->name('all.room.type');
        Route::get('/add/roomtype', 'AddRoomType')->name('add.room.type');
        Route::post('/roomtype/store', 'StoreRoomType')->name('room.type.store');
        Route::get('/edit/roomtype/{id}', 'EditRoomType')->name('edit.room.type');
        Route::post('/roomtype/update/store', 'StoreUpdatedRoomtype')->name('roomtype.update.store');
        Route::get('/delete/roomtype/{id}', 'DeleteRoomtype')->name('delete.room.type');        
    });
});

//Admin group middleware
Route::middleware(['auth', 'roles:admin'])->group(function() {
    //Using grouping method to handle the controller and routes
    Route::controller(RoomController::class)->group(function() {
        Route::get('/edit/room/{id}', 'EditRoom')->name('edit.room');
        Route::post('/room/update/{id}', 'StoreUpdatedRoom')->name('room.store');  
        Route::get('/delete/room/gallery/{id}', 'DeleteRoomGalleryImage')->name('delete.room.gallery.image');  
        Route::post('/room/no/store/{id}', 'StoreRoomNumber')->name('room.number.store');
        Route::get('/edit/room/no/{id}', 'EditRoomNumber')->name('edit.room.number');
        Route::post('/room/no/update/store', 'StoreUpdatedRoomNumber')->name('room.number.update.store');
        Route::get('/delete/room/no/{id}', 'DeleteRoomNumber')->name('delete.room.number');
    });
});

//Public pages routes
//Using grouping method to handle the controller and routes
Route::controller(FrontEndRoomController::class)->group(function() {
    Route::get('/list/rooms', 'ListAllRoom')->name('list.all.rooms');
    Route::get('/show/room/{id}', 'ShowRoom')->name('show.room');
    Route::get('/bookings', 'BookingSearch')->name('booking.search');
    Route::get('/search/room/details/{id}/{check_in}/{check_out}/{person}', 'SearchedRoomDetails')->name('search.room.details');
    Route::get('/check/room/availability', 'CheckRoomAvailability')->name('check.room.availability');
});

//Auth middleware
Route::middleware(['auth'])->group(function() {
    //Using grouping method to handle the controller and routes
    Route::controller(BookingController::class)->group(function() {
        Route::post('/booking/store/{id}', 'StoreUserBooking')->name('user.booking.store');
        Route::get('/checkout', 'Checkout')->name('checkout');
        Route::post('/checkout/store', 'StoreCheckout')->name('checkout.store');
        Route::match(['get', 'post'],'/stripe_pay', [BookingController::class, 'stripe_pay'])->name('stripe_pay');
    });
});

//Admin group middleware
Route::middleware(['auth', 'roles:admin'])->group(function() {
    //Using grouping method to handle the controller and routes
    Route::controller(BookingController::class)->group(function() {
        Route::get('/all/booking', 'AllBooking')->name('all.booking');
        Route::get('/edit/booking/{id}', 'EditBooking')->name('edit.booking');
        Route::post('/update/booking/{id}', 'StoreFinalizedBooking')->name('update.booking.status');
        Route::post('/update/booking/details/{id}', 'StoreUpdatedBookingDetails')->name('update.booking.details');
        Route::get('/assign/room/{id}', 'AssignRoom')->name('assign.room');
        Route::get('/assign/room/store/{id}/{room_number_id}', 'StoreAssignRoom')->name('assign.room.store');
        Route::get('/delete/assigned/room/{id}', 'DeleteAssignedRoom')->name('delete.assigned.room');
    });
});

//Admin group middleware
Route::middleware(['auth', 'roles:admin'])->group(function() {
    //Using grouping method to handle the controller and routes
    Route::controller(RoomListController::class)->group(function() {
        Route::get('/all/room/list', 'AllRoomList')->name('all.room.list');
    });
});


