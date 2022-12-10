<?php

namespace App\Http\Controllers;

use App\Enums\QuestionTypeEnum;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class AddQustionToLesson extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'lesson_id' => 'required',
            'type' => ['required', 'string', new Enum(QuestionTypeEnum::class)],
//            'order' => ['required', 'integer', 'min:1', 'unique:slides,order,NULL,_id,lesson_id,' . $request->lesson_id],
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

        //create slide

        $slide = $lesson->slides()->create([
            'type' => 'question',
            'lesson_id' => $request->lesson_id,
            'question_type' => $request->type,
            'order' => $lesson->slides()->count() + 1,
        ]);

        return $slide;


    }
}
