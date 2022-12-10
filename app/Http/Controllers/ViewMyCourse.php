<?php

namespace App\Http\Controllers;

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
        $course = $user->courses()->find($request->course_id);

        if(!$course){
            return response()->json([
                'message' => 'You are not allowed to view this course'
            ], 403);
        }

        return $course;
    }
}
