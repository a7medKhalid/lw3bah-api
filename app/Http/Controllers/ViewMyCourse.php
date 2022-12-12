<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class ViewMyCourse extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'course_id' => 'required',
        ]);

        //authorize request
        $user = $request->user();
        $course = Course::where('_id',$request->course_id)->where('teacher_id', $user->_id)->with('tags')->first();


        if(!$course){
            return response()->json([
                'message' => 'You are not allowed to view this course'
            ], 403);
        }

        return $course;
    }
}
