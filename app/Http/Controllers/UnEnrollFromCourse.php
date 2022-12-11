<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnEnrollFromCourse extends Controller
{

    public function __invoke(Request $request)
    {
        //request validation
        $request->validate([
            'course_id' => 'required',
        ]);

        $user = $request->user();

        $course = $user->enrollments()->where('course_id', $request->course_id)->first();

        if(!$course){
            return response()->json([
                'message' => 'You are not enrolled in this course'
            ], 403);
        }

        $course->is_valid = false;

        $course->save();

        return $course;



    }
}
