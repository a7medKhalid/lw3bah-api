<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class TeacherViewSectionDetails extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'section_id' => 'required',
        ]);

        //authorize request
        $user = $request->user();
        $section = Section::find($request->section_id);
        $course = $section->course;

        if(!$user->can('viewAsTeacher', $course)){
            return response()->json([
                'message' => 'You are not allowed to view this course'
            ], 403);
        }

        //return section
        return $section;

    }
}
