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



        //get slides

        $slides = $lesson->slides()->get()->toArray();

        //swap slide place to new order
        $slideWithUpdatedOrder = $slides[array_search($slide->_id, array_column($slides, '_id'))];
        $slideToSwap = $slides[array_search($request->order, array_column($slides, 'order'))];

        //remove slide with updated order
        $slides = array_filter($slides, function($item) use ($slideWithUpdatedOrder){
            return $item['_id'] != $slideWithUpdatedOrder['_id'];
        });

        //insert slide with updated order after slide to swap
        array_splice($slides, array_search($slideToSwap['_id'], array_column($slides, '_id')) + 1, 0, [$slideWithUpdatedOrder]);

        //update order of all slides
        foreach ($slides as $key => $slide){
            $slide = Slide::find($slide['_id']);
            $slide->update([
                'order' => $key + 1,
            ]);
            $slide->save();
        }

        return $lesson->slides()->get();


    }
}
