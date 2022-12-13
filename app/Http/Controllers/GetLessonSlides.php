<?php

namespace App\Http\Controllers;

use App\Enums\ContentTypeEnum;
use App\Enums\QuestionTypeEnum;
use App\Models\Lesson;
use Illuminate\Http\Request;

class GetLessonSlides extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'lesson_id' => 'required',
        ]);

        //authorize request
        $lesson = Lesson::find($request->lesson_id);

        //get slide details

        $slides = $lesson->slides;

        $slides = $slides->map(function ($slide) {
            if ($slide->type == 'content') {
                if ($slide->content_type == ContentTypeEnum::text) {
                    return $slide;
                }

                if ($slide->content_type == ContentTypeEnum::mediaAndText) {
                    $slide = [
                        '_id' => $slide->_id,
                        'type' => $slide->type,
                        'content_type' => $slide->content_type,
                        'order' => $slide->order,
                        'media' => $slide->media,
                        'body' => $slide->body,
                    ];

                    return $slide;
                }

            }
            elseif ($slide->type == 'question') {
                if ($slide->question_type == QuestionTypeEnum::multipleChoice) {
                    $slide = [
                        '_id' => $slide->_id,
                        'type' => $slide->type,
                        'question_type' => $slide->question_type,
                        'order' => $slide->order,
                        'answers' => $slide->answers,
                    ];

                    return $slide;
                }
                if ($slide->question_type == QuestionTypeEnum::trueFalse) {
                    $slide = [
                        '_id' => $slide->_id,
                        'type' => $slide->type,
                        'question_type' => $slide->question_type,
                        'order' => $slide->order,
                        'answers' => $slide->answers,
                    ];

                    return $slide;
                }
            }
            return $slide;
        });


        //return slides

        return $slides;
    }
}
