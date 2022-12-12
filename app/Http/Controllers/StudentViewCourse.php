<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
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
        $user = $request->user('sanctum');

        //get course
        $course = Course::where('_id',$request->course_id)->with('sections.lessons')->first();

//        if(!$user->can('view', $course)){
//            return response()->json([
//                'message' => 'You are not allowed to view this course'
//            ], 403);
//        }

        //if user enrolled in course return lessons with progress

        $enrollment = $user?->enrollments()->where('course_id', $course->_id)->first();

        if($enrollment) {
            $finishedLessons = $enrollment->finished_lessons;
            $finishedSections = $enrollment->finished_sections;

            if ($finishedLessons) {
                $course->sections->map(function ($section) use ($finishedLessons) {
                    $section->lessons->map(function ($lesson) use ($finishedLessons) {
                        $lesson->finished = in_array($lesson->_id, $finishedLessons);
                        return $lesson;
                    });
                    return $section;
                });
            }

            if ($finishedSections) {
                $course->sections->map(function ($section) use ($finishedSections) {
                    $section->finished = in_array($section->_id, $finishedSections);
                    return $section;
                });
            }


        }



        return $course;


    }
}
