<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReminderController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


//reminder system
Route::get('/reminder/dashboard',  [ReminderController::class, 'index'])->name('reminder.dashboard')->middleware(['auth']);
Route::get('/reminder/dashboard/list/due/{month}',  [ReminderController::class, 'list_due'])->name('reminder.list.due')->middleware(['auth']);


require __DIR__.'/auth.php';