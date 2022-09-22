<?php

use App\Models\Book;
use Illuminate\Support\Facades\Http;
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

Route::get('{any}', function () {
//    $res=Http::get('https://fakerapi.it/api/v1/books?_quantity=100')->body();
//
//    foreach (json_decode($res,true)['data'] as $i =>$value){
//        if($i==10){
//        Book::create($value);
//        }
//    }
    return view('app');
})->where('any','.*');
