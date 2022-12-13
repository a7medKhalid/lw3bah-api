<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Streak;
use Illuminate\Http\Request;

class FinishLesson extends Controller
{

    public function __invoke(Request $request)
    {
        //validate request
        $request->validate([
            'lesson_id' => 'required',
        ]);


        $user = $request->user();

        $lesson = Lesson::find($request->lesson_id);
        $section = $lesson->section;
        $course = $section->course;

        //check if user is enrolled in course
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if(!$enrollment){
            $enrollment = $user->enrollments()->create([
                'course_id' => $course->_id,
                'finished_lessons' => [],
                'finished_sections' => [],
                'is_finished' => false,
                'is_valid' => true,
            ]);
        }

        $enrollment->finished_lessons = array_unique(array_merge($enrollment->finished_lessons, [$lesson->_id]));

        //check if user finished section
        $finishedSection = $section->lessons()->count() == count($enrollment->finished_lessons);

        if($finishedSection){
            $enrollment->finished_sections = array_unique(array_merge($enrollment->finished_sections, [$section->_id]));
        }

        //check if user finished course
        $finishedCourse = $course->sections()->count() == count($enrollment->finished_sections);

        if($finishedCourse){
            $enrollment->is_finished = true;
        }

        $enrollment->save();

        //count points and add it to user

        $lessonPoints = $lesson->slides->map(function($slide){
            if ($slide->type == 'question') {
                return 10;
            } else {
                return 5;
            }
        });

        $user->points += $lessonPoints->sum();
        $user->save();

        //add streak for user
        $streak = $user->streaks()->create([
            'course_id' => $course->_id,
        ]);

        return $enrollment;


    }
}
