<?php

use App\Http\Controllers\API\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'books','middleware' => 'auth:sanctum'], function() {
    Route::get('/', [BooksController::class,'index']);
    Route::post('/', [BooksController::class,'filterBook']);
    Route::post('add', [BooksController::class,'add']);
    Route::post('update/{id}', [BooksController::class,'update']);
    Route::get('edit/{id}', [BooksController::class,'edit']);
    Route::delete('delete/{id}', [BooksController::class,'delete']);
});
