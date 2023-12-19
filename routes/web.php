<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'index']);
Route::get('/users', [UserController::class,'getUsers'])->name('users');
Route::post('/users', [UserController::class,'saveData'])->name('users.store');
// Route::post('/saveData', function(){
//     [UserController::class, 'saveData'];
// });
