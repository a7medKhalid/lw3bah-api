<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetEnrolledCourses extends Controller
{

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $enrollments = $user->enrollments()->get();

        $courses = $enrollments->map(function($enrollment){
            return $enrollment->course->with('teacher')->get();
        });

        return $courses;


    }
}
