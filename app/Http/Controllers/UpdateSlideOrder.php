<?php

namespace App\Http\Controllers;

use App\Actions\OrderItems;
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




        $slides = $lesson->slides()->get();

        $slides = OrderItems::run($slides, $request->slide_id, $request->order);

        // loop through the slides and update the order
        foreach ($slides as $key => $slide) {
            $slide = Slide::find($slide['_id']);
            $slide->order = $key + 1;
            $slide->save();
        }


        return $lesson->slides()->get();


    }
}
