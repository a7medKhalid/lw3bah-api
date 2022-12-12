<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Tag;
use Illuminate\Http\Request;

class UpdateCourseDetails extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'course_id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
            'tags' => 'required|array',
            'tags.*' => 'required|string',
        ]);

        //authorize request
        $user = $request->user();
        $course = Course::find($request->course_id);

        if (!$user->can('update', $course)) {
            return response()->json([
                'message' => 'You are not allowed to update this course'
            ], 403);
        }

        //update course details
        $course->update([
            'title' => $request->course_name,
            'description' => $request->course_description,
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
