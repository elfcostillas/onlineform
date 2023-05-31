<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\MainController;
use  App\Http\Controllers\FTPController;
use  App\Http\Controllers\LeaveController;
use  App\Http\Controllers\UserController;
use  App\Http\Controllers\AttendanceController;


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
    Route::get('page/{page}',[FTPController::class,'index2']);
    Route::get('create',[FTPController::class,'create']);
    Route::post('create',[FTPController::class,'saveCreate']);
    Route::get('scheds/{type}',[FTPController::class,'getSched']);
    Route::get('sendSMS',[FTPController::class,'sendSMS']);
      
});

Route::middleware('auth')->prefix('ftp_approval')->group(function(){
    
    Route::get('/',[FTPController::class,'pending']);
    Route::post('approve',[FTPController::class,'approve']);
    Route::post('deny',[FTPController::class,'deny']);
    // Route::get('create',[FTPController::class,'create']);
    // Route::post('create',[FTPController::class,'saveCreate']);
    // Route::get('scheds/{type}',[FTPController::class,'getSched']);
    // Route::get('sendSMS',[FTPController::class,'sendSMS']);
      
});

Route::middleware('auth')->prefix('leave-request')->group(function(){
    Route::get('/',[LeaveController::class,'index']);
    Route::get('create',[LeaveController::class,'create']);
    Route::post('edit',[LeaveController::class,'edit']);
    Route::post('post-leave',[LeaveController::class,'saveLeave']);
});

Route::middleware('auth')->prefix('leave-approval')->group(function(){
    Route::get('/',[LeaveController::class,'listForApproval']);
    Route::post('approve',[LeaveController::class,'approve']);
    Route::post('deny',[LeaveController::class,'deny']);
});


Route::middleware('auth')->prefix('attendance')->group(function(){
    Route::get('/',[AttendanceController::class,'index']);
    Route::get('get-periods/{year}/{month}',[AttendanceController::class,'getPeriods']);
    Route::get('get-dtr/{period_id}',[AttendanceController::class,'getDTR']);
});

Route::middleware('auth')->prefix('user')->group(function(){
    
    Route::get('copy',[UserController::class,'copy']);

      
});


require __DIR__.'/auth.php';
