<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class AddLessonTOSection extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'section_id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        //authorize request
        $section = Section::find($request->section_id);
        $course = $section->course;
        $user = $request->user();

        if(!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }

        //create lesson
        $lesson = $section->lessons()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return $lesson;
    }
}
