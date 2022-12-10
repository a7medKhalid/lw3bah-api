<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class UpdateSectionDetails extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'section_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        //authorize request

        $user = $request->user();
        $section = Section::find($request->section_id);
        $course = $section->course;

        if(!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }

        $maxOrder = $course->sections()->max('order');
        if ($maxOrder == null) {
            $maxOrder = 1;
        }

        $request->validate([
            'order' => ['required', 'integer', 'min:1', 'max:' . $maxOrder],
        ]);

        //update section
        $section->update([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order,
        ]);



        return $section;
    }
}
