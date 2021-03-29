<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ReminderSendController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\AccountsController;


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
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


//reminder system
Route::get('/reminder/dashboard',  [ReminderController::class, 'index'])->name('reminder.dashboard')->middleware(['auth']);
Route::get('/reminder/dashboard/list/due/{month}',  [ReminderController::class, 'list_due'])->name('reminder.list.due')->middleware(['auth']);

//reminder send system

//send email
Route::get('/reminder/send/email/{month}',  [ReminderSendController::class, 'email'])->name('reminder.send.email')->middleware(['auth']);
//send sms
Route::get('/reminder/send/sms/{month}',  [ReminderSendController::class, 'sms'])->name('reminder.send.sms')->middleware(['auth']);
//print print
Route::get('/reminder/send/print/{month}',  [ReminderSendController::class, 'print'])->name('reminder.send.print')->middleware(['auth']);


//SMS System
Route::get('/sms/test',  [SMSController::class, 'test'])->name('sms.test')->middleware(['auth']);

//list + archived dashboards
Route::get('/sms/dashboard',  [SMSController::class, 'dashboard'])->name('sms.dashboard')->middleware(['auth']);
Route::get('/sms/archived',  [SMSController::class, 'archived'])->name('sms.archived')->middleware(['auth']);

//new form + post form send and validation
Route::get('/sms/new',  [SMSController::class, 'new'])->name('sms.new')->middleware(['auth']);
Route::post('/sms/send',  [SMSController::class, 'send'])->name('sms.send')->middleware(['auth']);


//archive + activate switch
Route::get('/sms/archive/{id}',  [SMSController::class, 'archive'])->name('sms.archive')->middleware(['auth']);
Route::get('/sms/activate/{id}',  [SMSController::class, 'activate'])->name('sms.activate')->middleware(['auth']);

//view conversation
Route::get('/sms/view/{id}',  [SMSController::class, 'view'])->name('sms.view')->middleware(['auth']);

//external api auth route
Route::post('/sms/recieve',  [SMSController::class, 'recieve'])->name('sms.recieve');


//accounts system

//display form
Route::get('/accounts/dashboard',  [AccountsController::class, 'index'])->name('accounts.dashboard')->middleware(['auth']);
Route::post('/accounts/upload',  [AccountsController::class, 'upload'])->name('accounts.upload')->middleware(['auth']);

Route::get('/accounts/proccess/{file}',  [AccountsController::class, 'proccess'])->name('accounts.proccess')->middleware(['auth']);



require __DIR__.'/auth.php';
