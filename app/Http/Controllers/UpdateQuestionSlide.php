<?php

namespace App\Http\Controllers;

use App\Enums\QuestionTypeEnum;
use App\Models\Slide;
use Illuminate\Http\Request;

class UpdateQuestionSlide extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $maxOrder = Slide::where('lesson_id', $request->lesson_id)->max('order')??1;
        $request->validate([
            'slide_id' => 'required',
            'order' => ['required', 'integer', 'min:1', 'max:' . $maxOrder, 'unique:slides,order,' . $request->slide_id . ',_id,lesson_id,' . $request->lesson_id],
        ]);

        //get slide
        $slide = Slide::find($request->slide_id);
        $slideType = $slide->question_type;


        //authorize request
        $user = $request->user();
        $course = $slide->lesson->section->course;

        if (!$user->can('update', $course)) {
            return response()->json([
                'message' => 'You are not authorized to update this slide',
            ], 403);
        }

        //update slide order
        $slide->order = $request->order;


        //validate request based on slide type
        if ($slideType == 'multipleChoice') {
            $request->validate([
                'title' => 'required|string',
                'answers' => 'required|array|size:4',
                'answers.*.body' => 'required|string',
                'answers.*.is_correct' => 'required|boolean',
            ]);
        } elseif ($slideType == 'trueOrFalse') {
            $request->validate([
                'title' => 'required|string',
                'answers' => 'required|array|size:2',
                'answers.*.body' => 'required|string',
                'answers.*.is_correct' => 'required|boolean',
            ]);
        }


        //update slide based on slide type

        if ($slideType == QuestionTypeEnum::multipleChoice) {
            $slide->title = $request->title;

            //create  answers
            $slide->answers()->create([
                'body' => $request->answers[0]['body'],
                'is_correct' => $request->answers[0]['is_correct'],
            ]);
            $slide->answers()->create([
                'body' => $request->answers[1]['body'],
                'is_correct' => $request->answers[1]['is_correct'],
            ]);
            $slide->answers()->create([
                'body' => $request->answers[2]['body'],
                'is_correct' => $request->answers[2]['is_correct'],
            ]);
            $slide->answers()->create([
                'body' => $request->answers[3]['body'],
                'is_correct' => $request->answers[3]['is_correct'],
            ]);

        } else if ($slideType == QuestionTypeEnum::trueFalse) {
            $slide->title = $request->title;

            //create  answers
            $slide->answers()->create([
                'body' => $request->answers[0]['body'],
                'is_correct' => $request->answers[0]['is_correct'],
            ]);
            $slide->answers()->create([
                'body' => $request->answers[1]['body'],
                'is_correct' => $request->answers[1]['is_correct'],
            ]);
        }


        $slide->save();

        return $slide;
    }
}
