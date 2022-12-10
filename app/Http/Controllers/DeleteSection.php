<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class DeleteSection extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'section_id' => 'required|exists:sections,_id',
        ]);

        //get section
        $section = Section::find($request->section_id);
        $course = $section->course;

        //Authorize request
        $user = $request->user();
        if(!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not authorized to delete this section',
            ],403);
        }

        //delete section
        $section->delete();

        return $section;
    }
}
