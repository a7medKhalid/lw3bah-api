<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PublishCourse extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'course_id' => 'required',
            'publish' => 'required|boolean',
        ]);

        //get course
        $user = $request->user();
        $course = Course::find($request->course_id);

        //Authorize request
        $user->can('update', $course);

        //publish course
        $course->is_published = $request->publish;

        //save course
        $course->save();

        //return response

        return $course;
    }
}
