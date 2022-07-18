<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;

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
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


//profile
Route::put('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');
Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/profile/{id}', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/destroy/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
Route::get('/subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
Route::post('/subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
Route::get('/subscription/{subscription}', [SubscriptionController::class, 'show'])->name('subscription.show');
Route::get('/subscription/{subscription}/edit', [SubscriptionController::class, 'edit'])->name('subscription.edit');
Route::put('/subscription/{subscription}', [SubscriptionController::class, 'update'])->name('subscription.update');
Route::delete('/subscription/{subscription_id}', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');



Route::get('/about', function () {
    return view('about');
})->name('about');
