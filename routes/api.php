<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitedPersonController;
use App\Http\Controllers\FiendshipController;
use App\Http\Controllers\AcceptFriendshipsController;

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


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


Route::group(["middleware"=> "auth:api"],function () {
    
    Route::post('invite', [InvitedPersonController::class, 'store']);
    Route::put('invite/{invitedPerson}', [InvitedPersonController::class, 'update']);
    Route::post('friendship/{recipient}', [FiendshipController::class, 'store']);
    Route::delete('friendship/{user}', [FiendshipController::class] );
    Route::get('accept/friendship/',[AcceptFriendshipsController::class, 'index']);
    Route::post('accept/friendship/{sender}', [AcceptFriendshipsController::class, 'store']);
    Route::delete('accept/friendship/{sender}', [AcceptFriendshipsController::class, 'destroy']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResources(['invitations' => InvitationController::class]);
    Route::get('friendship/{query}', [FiendshipController::class, 'search']);
}); 
