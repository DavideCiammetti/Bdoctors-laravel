<?php

use App\Http\Controllers\Api\apiGraph\GraphController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\MessagesController;
use App\Http\Controllers\Api\ReviewsController;
use App\Http\Controllers\Api\VotesController;
use App\Models\Guest\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// index
Route::get('doctors', [DoctorController::class, 'index']);
// show
Route::get('doctors/{slug}', [DoctorController::class, 'show']);
// invio di recenzioni dall'utente
Route::post('reviews', [ReviewsController::class, 'store'])->name('reviews.store');
// invio messaggi dall'utente
Route::post('messages', [MessagesController::class, 'store'])->name('messages.store');
// invio voto da utente
Route::post('votes', [VotesController::class, 'store'])->name('votes.store');
// sponspored
Route::get('sponsor', [DoctorController::class, 'sponsor']);
// advanced search
Route::get('doctorsadvanced', [DoctorController::class, 'advancedSearch']);

Route::middleware(['web', 'auth', 'api'])->group(function () {
    // messages per graph
    Route::get('graph', [GraphController::class, 'index']);
    Route::get('graph/votes', [GraphController::class, 'indexVotes']);
});
