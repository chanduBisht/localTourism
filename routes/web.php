<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

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

Route::prefix('admin')->group(base_path('routes/admin.php'));
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('package', [FrontendController::class, 'package'])->name('package');
Route::get('destination', [FrontendController::class, 'destination'])->name('destination');

Route::get('about', [FrontendController::class, 'about'])->name('about');
Route::get('service', [FrontendController::class, 'service'])->name('service');
Route::get('blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('blog-detail/{blog}', [FrontendController::class, 'blogdetail'])->name('blog-detail');
Route::get('guide', [FrontendController::class, 'guide'])->name('guide');

Route::get('testimonial', function () {
    return view('testimonial');
})->name('testimonial');

Route::get('contact', function () {
    return view('contact');
})->name('contact');

Route::get('test', function () {
    return view('test');
})->name('test');
