<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\SMSController;


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


//SMS System
Route::get('/sms/test',  [SMSController::class, 'test'])->name('sms.test')->middleware(['auth']);
Route::get('/sms/dashboard',  [SMSController::class, 'dashboard'])->name('sms.dashboard')->middleware(['auth']);

Route::get('/sms/new',  [SMSController::class, 'new'])->name('sms.new')->middleware(['auth']);
Route::post('/sms/send',  [SMSController::class, 'send'])->name('sms.send')->middleware(['auth']);

Route::get('/sms/archive/{id}',  [SMSController::class, 'archive'])->name('sms.archive')->middleware(['auth']);
Route::get('/sms/view/{id}',  [SMSController::class, 'archive'])->name('sms.view')->middleware(['auth']);


//external api auth route
Route::get('/sms/recieve',  [SMSController::class, 'recieve'])->name('sms.recieve');

require __DIR__.'/auth.php';
