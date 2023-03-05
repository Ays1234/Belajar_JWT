<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::namespace('Auth')->group(function (){
//     Route::post('register', 'AuthController');
//     Route::post('login', 'AuthController');
// });

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('add_bank', [BankController::class, 'add_bank']);
    Route::post('update_bank/{id}', [BankController::class, 'update_bank']);
    Route::post('delete_bank/{id}', [BankController::class, 'delete_bank']);
    // This add bank
   
});

// Route::get('bank', [BankController::class, 'índex']);

// Route::post('bank_add', [BankController::class, 'bank_add']);
// Route::post('refresh', [BankController::class, 'refresh']);
// Route::post('me', [BankController::class, 'me']);
