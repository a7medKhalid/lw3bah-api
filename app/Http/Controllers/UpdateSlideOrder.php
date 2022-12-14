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




        $slides = $lesson->slides()->get()->toArray();

        // get the slide that is being moved
        $slideToMove = $lesson->slides()->where('_id', $request->slide_id)->first();

        // get the slide that is being moved to
        $slideToMoveTo = $lesson->slides()->where('order', $request->order)->first();

        // get the index of the slide that is being moved
        $slideToMoveIndex = array_search($slideToMove->_id, array_column($slides, '_id'));

        // get the index of the slide that is being moved to
        $slideToMoveToIndex = array_search($slideToMoveTo->_id, array_column($slides, '_id'));

        // use splice to remove the slide that is being moved
        $slideToMove = array_splice($slides, $slideToMoveIndex, 1);
        // use splice to insert the slide that is being moved to the new position
        array_splice($slides, $slideToMoveToIndex, 0, $slideToMove);

        // loop through the slides and update the order
        foreach ($slides as $key => $slide) {
            $slide = Slide::find($slide['_id']);
            $slide->order = $key + 1;
            $slide->save();
        }


        return $lesson->slides()->get();


    }
}
