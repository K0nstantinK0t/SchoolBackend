<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::post('/register', [AuthController::class, 'register']);
//Route::post('/token', [AuthController::class, 'token']);

Route::apiResources([
    'teachers' => \App\Http\Controllers\TeacherController::class,
    'schoolclasses' => \App\Http\Controllers\SchoolClassController::class,
]);
Route::post('students/{id}/remove', [\App\Http\Controllers\StudentController::class, 'destroy']);
Route::post('students', [\App\Http\Controllers\StudentController::class, 'store']);
Route::get('students', [\App\Http\Controllers\StudentController::class, 'index']);
Route::get('students/youngest', [\App\Http\Controllers\StudentController::class, 'youngest']);
Route::get('/schoolclasses/{id}/withStudentsAndTeachers', [\App\Http\Controllers\SchoolClassController::class, 'getWithStudentsAndTeachers']);
Route::post('/schoolclasses/{id}/setTeacher', [\App\Http\Controllers\SchoolClassController::class, 'setTeacher']);
//Route::middleware('auth:sanctum')->group(function() {
//    Route::get('/user', function (Request $request) {
//        return $request->user();
//    });
//    Route::post('/logout', [AuthController::class, 'logOut']);
//});
