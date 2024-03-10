<?php

use App\Http\Controllers\Api\DoctorController;
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
// sponspored
Route::get('sponsor', [DoctorController::class, 'sponsor']);