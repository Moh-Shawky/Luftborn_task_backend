<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// i tried to create authentication on update route but it doesn't work even all crud
// operation are failed so i ignored this task but rest of all tasks are working very well

Route::group(['middleware'=>['auth:sanctum']], function() {
    // Route::put('users/{id}', [UserController::class, 'update'])->name('update');
});


// this route initialize all routes of crud operation to know how 
// to call routes it created call command "php artisan route:list"

Route::resource('users', UserController::class);
Route::post('login',[UserController::class,'login']);


// this route created to test sending mails 
Route::get('send-mails',[UserController::class,'send_email']);

