<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\UserBankAccountController;

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
      // This add bank
    Route::post('add_bank', [BankController::class, 'add_bank']);
    Route::post('update_bank/{id}', [BankController::class, 'update_bank']);
    Route::post('delete_bank/{id}', [BankController::class, 'delete_bank']);
  
    // This add user_bank_account
    Route::post('add_user_bank_account', [UserBankAccountController::class, 'add_user_bank_account']);
    Route::post('update_user_bank_account/{id}', [UserBankAccountController::class, 'update_user_bank_account']);
    Route::post('delete_user_bank_account/{id}', [UserBankAccountController::class, 'delete_user_bank_account']);
  
});
