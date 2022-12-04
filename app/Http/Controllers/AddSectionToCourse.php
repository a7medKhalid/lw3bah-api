<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class AddSectionToCourse extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'course_id' => 'required',
            'title' => 'required|string',
        ]);

        //authorize request
        $course = Course::find($request->course_id);

        $user = $request->user();

        if(!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }

        //add section to course
        $course->sections()->create([
            'title' => $request->title,
        ]);

        $course->save();

        return $course->sections;
    }
}
