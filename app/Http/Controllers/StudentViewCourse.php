<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class StudentViewCourse extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'course_id' => 'required',
        ]);

        //authorize request
        $user = $request->user();

        //get course
        $course = Course::where('_id',$request->course_id)->with('sections.lessons')->first();

        if(!$user->can('view', $course)){
            return response()->json([
                'message' => 'You are not allowed to view this course'
            ], 403);
        }

        return $course;


    }
}
