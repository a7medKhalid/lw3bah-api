<?php

use App\Http\Controllers\AddContentToLesson;
use App\Http\Controllers\AddLessonTOSection;
use App\Http\Controllers\AddQustionToLesson;
use App\Http\Controllers\AddSectionToCourse;
use App\Http\Controllers\AddTagsToCourse;
use App\Http\Controllers\CreateNewCourse;
use App\Http\Controllers\CreateToken;
use App\Http\Controllers\DeleteCourse;
use App\Http\Controllers\DeleteLesson;
use App\Http\Controllers\DeleteSection;
use App\Http\Controllers\DeleteSlide;
use App\Http\Controllers\FinishLesson;
use App\Http\Controllers\GetEnrolledCourses;
use App\Http\Controllers\GetLessonSlides;
use App\Http\Controllers\GetProfile;
use App\Http\Controllers\GetPublishedTags;
use App\Http\Controllers\PublishCourse;
use App\Http\Controllers\StudentViewCourse;
use App\Http\Controllers\StudentViewCourses;
use App\Http\Controllers\TeacherViewLessonDetails;
use App\Http\Controllers\TeacherViewLessons;
use App\Http\Controllers\TeacherViewSectionDetails;
use App\Http\Controllers\TeacherViewSections;
use App\Http\Controllers\TeacherViewSlideDetails;
use App\Http\Controllers\TeacherViewSlides;
use App\Http\Controllers\UnEnrollFromCourse;
use App\Http\Controllers\UpdateContentSLide;
use App\Http\Controllers\UpdateCourseDetails;
use App\Http\Controllers\UpdateLessonDetails;
use App\Http\Controllers\UpdateLessonOrder;
use App\Http\Controllers\UpdateQuestionSlide;
use App\Http\Controllers\UpdateSectionDetails;
use App\Http\Controllers\UpdateSlideOrder;
use App\Http\Controllers\ViewMyCourse;
use App\Http\Controllers\ViewMyCourses;
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

Route::post('/create-token', CreateToken::class);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//shared routes
Route::get('get-published-tags', GetPublishedTags::class);



//teacher authenticated routes
Route::middleware('auth:sanctum')->group(function () {


    //course
    Route::get('view-my-course',ViewMyCourse::class);
    Route::get('view-my-courses',ViewMyCourses::class);

    Route::post('create-new-course', CreateNewCourse::class);
    Route::post('add-tags-to-course', AddTagsToCourse::class);
    Route::post('publish-course', PublishCourse::class);
    Route::post('update-course-details', UpdateCourseDetails::class);
    Route::post('delete-course', DeleteCourse::class);

    //section
    Route::get('teacher-view-section-details', TeacherViewSectionDetails::class);
    Route::get('teacher-view-sections', TeacherViewSections::class);

    Route::post('add-section-to-course', AddSectionToCourse::class);
    Route::post('update-section-details', UpdateSectionDetails::class);
    Route::post('delete-section', DeleteSection::class);


    //lesson
    Route::get('teacher-view-lesson-details', TeacherViewLessonDetails::class);
    Route::get('teacher-view-lessons', TeacherViewLessons::class);

    Route::post('add-lesson-to-section', AddLessonTOSection::class);
    Route::post('update-lesson-details', UpdateLessonDetails::class);
    Route::post('update-lesson-order', UpdateLessonOrder::class);
    Route::post('delete-lesson', DeleteLesson::class);

    //slide
    Route::get('teacher-view-slide-details', TeacherViewSlideDetails::class);
    Route::get('teacher-view-slides', TeacherViewSlides::class);

    Route::post('update-slide-order', UpdateSlideOrder::class);

    Route::post('add-content-to-lesson', AddContentToLesson::class);
    Route::post('update-content-slide', UpdateContentSLide::class);

    Route::post('add-question-to-lesson', AddQustionToLesson::class);
    Route::post('update-question-slide', UpdateQuestionSlide::class);

    Route::post('delete-slide', DeleteSlide::class);
});

    //student  routes

Route::get('student-view-courses', StudentViewCourses::class);
Route::get('student-view-course', StudentViewCourse::class);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('finish-lesson', FinishLesson::class);
    Route::post('unenroll-from-course', UnEnrollFromCourse::class);

    Route::get('get-lesson-slides', GetLessonSlides::class);
    Route::get('get-enrolled-courses', GetEnrolledCourses::class);

    Route::get('get-profile', GetProfile::class);

});





//guest routes

include __DIR__ . '/auth.php';
