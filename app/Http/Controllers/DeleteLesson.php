<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class DeleteLesson extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'lesson_id' => 'required|exists:lessons,_id',
        ]);

        //get lesson
        $lesson = Lesson::find($request->lesson_id);

        //Authorize request
        $user = $request->user();
        $course = $lesson->section->course;

        if ($user->cannot('update', $course)) {
            return response()->json([
                'message' => 'You are not authorized to delete this lesson',
            ], 403);
        }

        //delete lesson
        $lesson->delete();

        return $lesson;
    }
}
