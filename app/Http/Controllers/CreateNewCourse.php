<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Tag;
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
            'tags' => 'required|array',
            'tags.*' => 'required|string',
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

        //get tags if they exist or create them
        $tags = collect($request->tags)->map(function($tag){
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $tag->increment('times_used');
            $tag->save();
            return $tag;
        });

        //attach tags to course

        $tags = $tags->pluck('_id')->toArray();
        $course->tags()->sync($tags);


        $course->save();


        return $course;

    }
}
