<?php

namespace App\Http\Controllers;

use App\Actions\OrderItems;
use App\Models\Lesson;
use App\Models\Slide;
use Illuminate\Http\Request;

class UpdateLessonOrder extends Controller
{

    public function __invoke(Request $request)
    {
        //request validation
        $request->validate([
            'lesson_id' => 'required',
        ]);

        $lesson = Lesson::find($request->lesson_id);

        $section = $lesson->section;

//        $maxOrder = $section->lessons()->max('order');

//        if ($maxOrder == null){
//            $maxOrder = 1;
//        }

//        $request->validate([
//            'order' => ['required', 'integer', 'min:1', 'max:' . $maxOrder],
//        ]);

        //authorize request
        $user = $request->user();
        $course = $section->course;

        if (!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }


        $lessons = $section->lessons()->get();

        $lessons = OrderItems::run($lessons, $request->lesson_id, $request->order);

        // loop through the slides and update the order
        foreach ($lessons as $key => $lesson) {
            $lesson = Lesson::find($lesson['_id']);
            $lesson->order = $key + 1;
            $lesson->save();
        }


        return $section->lessons()->get();
    }
}
