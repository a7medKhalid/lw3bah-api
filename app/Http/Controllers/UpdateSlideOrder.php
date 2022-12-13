<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Slide;
use Illuminate\Http\Request;

class UpdateSlideOrder extends Controller
{

    public function __invoke(Request $request)
    {
        //request validation
        $request->validate([
            'slide_id' => 'required',
            ]);

        $slide = Slide::find($request->slide_id);

        $lesson = $slide->lesson;

        $maxOrder = $lesson->slides()->max('order');

        if ($maxOrder == null){
            $maxOrder = 1;
        }

        $request->validate([
            'order' => ['required', 'integer', 'min:1', 'max:' . $maxOrder],
        ]);

        //authorize request
        $user = $request->user();
        $course = $lesson->section->course;

        if (!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }

        //update slide order
        $slide = $slide->update([
            'order' => $request->order,
        ]);

        $slide->save();

        return $slide;


    }
}
