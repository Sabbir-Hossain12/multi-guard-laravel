<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/user/dashboard',function ()
{
    return view('user-dashboard');
})->name('user.dashboard')->middleware(['is_user']);

Route::get('/admin/dashboard',function ()
{
    return view('admin-dashboard');
})->name('admin.dashboard')->middleware(['is_admin']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Admin Routes

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/register', [AdminController::class, 'createRegister'])
        ->name('register');

    Route::post('/register', [AdminController::class, 'storeRegister']);

    Route::get('/login', [AdminController::class, 'create'])
        ->name('login');

    Route::post('/login', [AdminController::class, 'store']);
});


Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function ()
{
   Route::get('/logout',[AdminController::class,'logout'])->name('logout'); 
});