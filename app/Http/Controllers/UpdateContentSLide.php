<?php

namespace App\Http\Controllers;

use App\Enums\ContentTypeEnum;
use App\Enums\SlideTypeEnum;
use App\Models\Media;
use App\Models\Slide;
use Illuminate\Http\Request;

class UpdateContentSLide extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
//        $maxOrder = Slide::where('lesson_id', $request->lesson_id)->max('order');
//        if ($maxOrder == null) {
//            $maxOrder = 1;
//        }
        $request->validate([
            'slide_id' => 'required',
            'order' => ['required', 'integer', 'min:1'],
        ]);

        //get slide
        $slide = Slide::find($request->slide_id);
        $slideType = $slide->content_type;


        //authorize request
        $user = $request->user();
        $course = $slide->lesson->section->course;

        if(!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not authorized to update this slide',
            ], 403);
        }

        //update slide order
        $slide->order = $request->order;


        //validate request based on slide type
        if($slideType == 'text') {
            $request->validate([
                'title' => 'required|string',
                'body' => 'required|string',
            ]);
        } else if($slideType == 'mediaAndText') {
            $request->validate([
                'media_type' => ['required', 'string', 'in:video,image,audio'],
                'media' => 'required|url',
                'body' => 'required|string',
            ]);
        }



        //update slide based on slide type

        if($slideType == ContentTypeEnum::text) {
            $slide->title = $request->title;
            $slide->body = $request->body;

        } else if($slideType == ContentTypeEnum::mediaAndText) {
            $slide->body = $request->body;

            //create media
            $slide->media()->create([
                'type' => $request->media_type,
                'url' => $request->media,
            ]);

        }

        $slide->save();

        return $slide;





    }
}
