<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\GroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------

*/
// Api Autontification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/users', [AuthController::class], 'index');
// end
Route::apiResource('/expenses', ExpenseController::class);
Route::apiResource('/tags', TagController::class);
Route::post('/expenses/{id}/tags', [ExpenseController::class, 'attachTags']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->group(function () {
    // Routes pour les groupes
    Route::get('/groups', [GroupController::class, 'index']);
    Route::post('/groups', [GroupController::class, 'store']);
    Route::get('/groups/{id}', [GroupController::class, 'show']);
    Route::delete('/groups/{id}', [GroupController::class, 'destroy']);
    // Routes pour les dépenses
    Route::post('/groups/{id}/expenses', [ExpenseController::class, 'store']);
    Route::get('/groups/{id}/expenses', [ExpenseController::class, 'index']);
    Route::delete('/groups/{id}/expenses/{expenseId}', [ExpenseController::class, 'destroy']);

    // Routes pour la gestion des membres
    Route::post('/groups/{id}/members', [GroupController::class, 'addMember']);
    Route::delete('/groups/{id}/members/{userId}', [GroupController::class, 'removeMember']);
});
