<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class TeacherViewLessonDetails extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request

        $request->validate([
            'lesson_id' => 'required',
        ]);

        //authorize request

        $user = $request->user();

        $lesson = Lesson::find($request->lesson_id);

        $course = $lesson->section->course;

        if(!$user->can('viewAsTeacher', $course)){
            return response()->json([
                'message' => 'You are not allowed to view this course'
            ], 403);
        }

        //return lesson

        return $lesson;


    }
}
