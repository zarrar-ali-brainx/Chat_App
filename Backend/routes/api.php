<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[RegisterController::class, 'store']);
Route::post('/login',[LoginController::class, 'check']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/conversations/{threadId}/messages', [MessageController::class, 'fetchMessages']);
});
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/conversations/{threadId}/messages', [MessageController::class, 'sendMessage']);
    Route::post('/conversations/{conversation}/group-messages', [MessageController::class, 'sendGroupMessage']);
    Route::delete('/messages/{messageId}', [MessageController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/conversations', [ConversationController::class, 'index']);
    Route::get('/conversations/check', [ConversationController::class, 'checkConversation']);


});
Route::post('/conversations', [ConversationController::class, 'create']);

Route::get('/conversations/{id}', [ConversationController::class, 'getConversation']);
