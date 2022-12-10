<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class UpdateLessonDetails extends Controller
{

    public function __invoke(Request $request)
    {

        //validate request
        $request->validate([
            'lesson_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);



        //authorize request
        $lesson = Lesson::find($request->lesson_id);
        $user = $request->user();
        $section = $lesson->section;
        $course = $section->course;

        if(!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }

        $maxOrder = $lesson->slides()->max('order');
        if ($maxOrder == null){
            $maxOrder = 1;
        }

        $request->validate([
            'order' => ['required', 'integer', 'min:1', 'max:' . $maxOrder],
            ]);


            //update lesson
        $lesson->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return $lesson;
    }
}
