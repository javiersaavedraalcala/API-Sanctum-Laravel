<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ProjectController;




Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('profile', [StudentController::class, 'profile']);
    Route::get('logout', [StudentController::class, 'logout']);
    
    Route::post('create-project', [ProjectController::class, 'createProject']);
    Route::get('list-project', [ProjectController::class, 'listProject']);
    Route::get('single-project/{id}', [ProjectController::class, 'singleProject']);
    Route::delete('delete-project/{id}', [ProjectController::class, 'deleteProject']);
});

Route::post('register', [StudentController::class, 'register']);
Route::post('login', [StudentController::class, 'login']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
