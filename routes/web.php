<?php

use App\Mail\mymail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


// Route::get('email-test', function(){
//     $details = [
//         'email'=> 'your_email@gmail.com',
//         'firstname'=>'mo',
//         'lastname'=>'shawky'
//     ];
//     dispatch(new App\Jobs\SendUserEmail($details));
//     dd('done');
//     });
