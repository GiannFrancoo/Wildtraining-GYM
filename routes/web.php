<?php

use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


//Routes for profile
Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/profile/{id}', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/destroy/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');

//Routes for subscriptions
Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
Route::get('/subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
Route::post('/subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
Route::get('/subscription/{subscription_id}', [SubscriptionController::class, 'show'])->name('subscription.show');
Route::get('/subscription/{subscription_id}/edit', [SubscriptionController::class, 'edit'])->name('subscription.edit');
Route::put('/subscription/{subscription_id}', [SubscriptionController::class, 'update'])->name('subscription.update');
Route::delete('/subscription/{subscription_id}', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');

//Routes for assistances
Route::get('/assistance', [AssistanceController::class, 'index'])->name('assistance.index');
Route::get('/assistance/create', [AssistanceController::class, 'create'])->name('assistance.create');
Route::post('/assistance', [AssistanceController::class, 'store'])->name('assistance.store');
Route::get('/assistance/{assistance_id}/edit}', [AssistanceController::class, 'edit'])->name('assistance.edit');
Route::put('/assistance/{assistance_id}', [AssistanceController::class, 'update'])->name('assistance.update');
Route::delete('/assistance/{assistance_id}', [AssistanceController::class, 'destroy'])->name('assistance.destroy');

//Routes for payments
Route::post('/payment/{id}', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/payment/user/{id}', [PaymentController::class, 'userSelected'])->name('payment.userSelected');
Route::get('/payment/users', [PaymentController::class, 'users'])->name('payment.users');
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
Route::get('/payment/edit/{id}', [PaymentController::class, 'edit'])->name('payment.edit');
Route::get('/payment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');
Route::put('/payment/update/{id}', [PaymentController::class, 'update'])->name('payment.update');

