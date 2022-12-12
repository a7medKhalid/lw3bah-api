<?php

namespace App\Http\Controllers;

use App\Enums\ContentTypeEnum;
use App\Enums\QuestionTypeEnum;
use App\Models\Slide;
use Illuminate\Http\Request;

class TeacherViewSlideDetails extends Controller
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

        if(!$user->can('viewAsTeacher', $course)){
            return response()->json([
                'message' => 'You are not allowed to view this slide'
            ], 403);
        }

        //get slide details

        if ($slide->type == 'content'){
            if ($slide->content_type == ContentTypeEnum::text){
                return $slide;
            }

            if ($slide->content_type == ContentTypeEnum::mediaAndText){
                $slide = [
                    'id' => $slide->_id,
                    'type' => $slide->type,
                    'content_type' => $slide->content_type,
                    'order' => $slide->order,
                    'media' => $slide->media,
                    'body' => $slide->body,
                ];

                return $slide;
            }

        }elseif ($slide->type == 'question'){
            if ($slide->question_type == QuestionTypeEnum::multipleChoice){
                $slide = [
                    'id' => $slide->_id,
                    'type' => $slide->type,
                    'question_type' => $slide->question_type,
                    'order' => $slide->order,
                    'answers' => $slide->answers,
                ];

                return $slide;
            }
            if ($slide->question_type == QuestionTypeEnum::trueFalse){
                $slide = [
                    'id' => $slide->_id,
                    'type' => $slide->type,
                    'question_type' => $slide->question_type,
                    'order' => $slide->order,
                    'answers' => $slide->answers,
                ];

                return $slide;
            }

        }

        return null;

    }
}
