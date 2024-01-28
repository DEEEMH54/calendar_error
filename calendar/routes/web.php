<?php
use App\Http\Controllers\calendarController;
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

Route::get('calendar', 'App\Http\Controllers\bookingController@index');
Route::post('calendar', [App\Http\Controllers\bookingController::class, 'store'])->name('calendar.store');
Route::put('calendar/update/{id}', [App\Http\Controllers\bookingController::class, 'update'])->name('calendar.update');