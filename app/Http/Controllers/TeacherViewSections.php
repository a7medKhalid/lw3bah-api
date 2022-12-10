<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class TeacherViewSections extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'course_id' => 'required',
        ]);

        //authorize request
        $user = $request->user();
        $course = Course::find($request->course_id);

        if(!$user->can('viewAsTeacher', $course)){
            return response()->json([
                'message' => 'You are not allowed to view this course'
            ], 403);
        }

        //return sections
        return $course->sections;

    }
}
