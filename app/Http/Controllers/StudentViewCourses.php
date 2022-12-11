<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class StudentViewCourses extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'category' => 'required|string',
        ]);

        //get courses

        $tag = Tag::where('name', $request->category)->first();

        $courses = $tag->courses()->with('teacher')->get();


        return $courses;

    }
}
