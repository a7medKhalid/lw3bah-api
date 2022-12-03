<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class CreateNewCourse extends Controller
{

    public function __invoke(Request $request)
    {

        $user = $request->user();


        //validate request

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        //authorize request

        if (!$user->can('create', Course::class)) {
            return response()->json([
                'message' => 'You are not allowed to create a course'
            ], 403);
        }

        //create new course

        $course = $user->courses()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);


        return $course;

    }
}
