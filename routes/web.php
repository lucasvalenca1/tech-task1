<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Make sure this controller exists and is imported

// Default welcome page route
Route::get('/', function () {
    return view('welcome');
});

// --- User CRUD Routes ---
// This single line defines all 7 standard RESTful routes for the UserController.
Route::resource('users', UserController::class);
