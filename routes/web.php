<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\MainController;
use  App\Http\Controllers\FTPController;
use  App\Http\Controllers\LeaveController;

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

// Route::get('/', function () {
//     return redirect('/dashboard');
// });

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

Route::get('/',[MainController::class,'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->prefix('ftp')->group(function(){
    
    Route::get('/',[FTPController::class,'index']);
    Route::get('create',[FTPController::class,'create']);
    Route::post('create',[FTPController::class,'saveCreate']);
    Route::get('scheds/{type}',[FTPController::class,'getSched']);
    Route::get('sendSMS',[FTPController::class,'sendSMS']);
      
});

Route::middleware('auth')->prefix('leave-request')->group(function(){
    
    Route::get('/',[LeaveController::class,'index']);
    Route::get('create',[LeaveController::class,'create']);
    
      
});

require __DIR__.'/auth.php';
