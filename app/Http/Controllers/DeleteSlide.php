<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;

class DeleteSlide extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'slide_id' => 'required',
        ]);

        //authorize request
        $user = $request->user();
        $slide = Slide::find($request->slide_id);
        $course = $slide->lesson->section->course;

        if(!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }

        //delete slide
        $slide->delete();

        return $slide;
    }
}
