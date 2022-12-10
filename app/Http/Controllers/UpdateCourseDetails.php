<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class UpdateCourseDetails extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'course_id' => 'required',
            'course_name' => 'required|string',
            'course_description' => 'required|string',
        ]);

        //authorize request
        $user = $request->user();
        $course = Course::find($request->course_id);

        if (!$user->can('update', $course)) {
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }

        //update course details
        $course->update([
            'title' => $request->course_name,
            'description' => $request->course_description,
        ]);

        return $course;
    }
}
