<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class DeleteCourse extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'course_id' => 'required|exists:courses,_id',
        ]);

        //get course
        $course = Course::find($request->course_id);

        //Authorize request
        $user = $request->user();
        if (!$user->can('delete', $course)) {
            abort(403);
        }

        //delete course
        $course->delete();

        return $course;

    }
}
