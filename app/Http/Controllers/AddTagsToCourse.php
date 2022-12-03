<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Tag;
use Illuminate\Http\Request;

class AddTagsToCourse extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'course_id' => 'required',
            'tags' => 'required|array',
            'tags.*' => 'required|string',
        ]);

        //authorize request
        $course = Course::find($request->course_id);
        $user = $request->user();

        if(!$user->can('update', $course)){
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }

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

        return $course->tags;
    }
}
