<?php

use App\Http\Controllers\Admin\BraintreeController;
use App\Http\Controllers\Admin\DashboardControllers;
use App\Http\Controllers\Admin\DoctorsController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware(['auth', 'verified', 'first.registration.check'])->name('admin.')->prefix('admin')->group(function () {

    Route::get('/', [DashboardControllers::class, 'index'])->name('dashboard');
    // Route::get('/doctors/{doctor}/edit', [DoctorsController::class, 'edit'])->name('doctors.edit');
    // route resource controller doctors
    Route::resource('doctors', DoctorsController::class);

    //Braintree
    Route::get('/payment', [BraintreeController::class, 'checkout'])->name('doctor.payment');
    Route::post('/checkout', [BraintreeController::class, 'processPayment'])->name('doctor.payment.checkout');

    //Messaggi
    Route::get('/messages', [MessagesController::class, 'index'])->name('doctor.messages');

    //recensioni
    Route::get('/reviews', [ReviewsController::class, 'index'])->name('doctor.reviews');

    // cancella account
    Route::post('user', [UserController::class, 'destroy'])->name('user.destroy');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
