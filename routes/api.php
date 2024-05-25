<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/token', [AuthController::class, 'token']);

Route::apiResources([
    'students' => \App\Http\Controllers\StudentController::class,
    'teachers' => \App\Http\Controllers\TeacherController::class,
    'schoolclasses' => \App\Http\Controllers\SchoolClassController::class,
]);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logOut']);
});
