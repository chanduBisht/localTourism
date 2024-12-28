<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\TaxiController;
use App\Http\Controllers\Admin\TrakingController;
use App\Http\Controllers\Admin\GuideController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ServiceController;

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

Route::group(['as' => 'admin.'], function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('loginInsert', [AuthController::class, 'loginInsert'])->name('login.insert');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('registration', [AuthController::class, 'registration'])->name('registration');
    Route::post('registerInsert', [AuthController::class, 'registerInsert'])->name('register.insert');

    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('adminLogin');

    Route::resource('roles', RoleController::class)->middleware('adminLogin');
    Route::resource('permissions', PermissionController::class)->middleware('adminLogin');
    Route::resource('places', PlaceController::class)->middleware('adminLogin');
    Route::resource('hotels', HotelController::class)->middleware('adminLogin');
    Route::resource('rooms', RoomController::class)->middleware('adminLogin');
    Route::resource('taxi', TaxiController::class)->middleware('adminLogin');
    Route::resource('traking', TrakingController::class)->middleware('adminLogin');
    Route::resource('guide', GuideController::class)->middleware('adminLogin');
    Route::resource('blog', BlogController::class)->middleware('adminLogin');
    Route::resource('service', ServiceController::class)->middleware('adminLogin');

    Route::post('editorImageAdd', [BlogController::class, 'editorImageAdd'])->name('blog.image.upload');
    Route::post('editorImageDelete', [BlogController::class, 'editorImageDelete'])->name('blog.image.delete');

});
