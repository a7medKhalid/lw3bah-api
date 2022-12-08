<?php

use App\Http\Controllers\AddContentToLesson;
use App\Http\Controllers\AddLessonTOSection;
use App\Http\Controllers\AddSectionToCourse;
use App\Http\Controllers\AddTagsToCourse;
use App\Http\Controllers\CreateNewCourse;
use App\Http\Controllers\PublishCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//hello world
Route::get('/hello', function () {
    return 'Hello World';
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


//authenticated routes
Route::middleware('auth:sanctum')->group(function () {

    //teacher routes
    Route::post('create-new-course', CreateNewCourse::class);
    Route::post('add-tags-to-course', AddTagsToCourse::class);
    Route::post('add-section-to-course', AddSectionToCourse::class);
    Route::post('add-lesson-to-section', AddLessonTOSection::class);
    Route::post('add-content-to-lesson', AddContentToLesson::class);
    Route::post('publish-course', PublishCourse::class);
});


//guest routes

