<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //create teacher
        $teacher = User::factory()->create([
            'name' => 'Teacher',
            'email' => 'teacher@email.com',
            'role' => 'teacher',
            ]);

        //create student
        $student = User::factory()->create([
            'name' => 'Student',
            'email' => 'student@email.com',
            'role' => 'student',
            ]);

        $course = $teacher->courses()->create([
            'title' => 'Laravel',
            'description' => 'Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.',
            'is_published' => true,
        ]);

        $course->tags()->create([
            'name' => 'Laravel',
        ]);

        $course->tags()->create([
            'name' => 'PHP',
            'is_published' => true,
        ]);

        $course->tags()->create([
            'name' => 'Backend',
            'is_published' => true,
        ]);

        $course->tags()->create([
            'name' => 'Web Development',
            'is_published' => true,
        ]);

        $course->tags()->create([
            'name' => 'Programming',
        ]);

        $course->tags()->create([
            'name' => 'Beginner',
        ]);

        $section = $course->sections()->create([
            'title' => 'Introduction',
            'description' => 'This is the introduction section',
        ]);

        $lesson = $section->lessons()->create([
            'title' => 'Introduction to Laravel',
            'description' => 'This is the introduction to Laravel lesson',
        ]);

        $slide = $lesson->slides()->create([
            'type' => 'content',
            'content_type' => 'text',
            'order' => 1,
            'body' => 'This is the first slide',
        ]);

        $slide = $lesson->slides()->create([
            'type' => 'content',
            'content_type' => 'text',
            'order' => 2,
            'body' => 'This is the second slide',
        ]);

        $slide = $lesson->slides()->create([
            'type' => 'content',
            'content_type' => 'text',
            'order' => 3,
            'body' => 'This is the third slide',
        ]);

        $slide = $lesson->slides()->create([
            'type' => 'question',
            'question_type' => 'multipleChoice',
            'order' => 4,
            'body' => 'This is the fourth slide',
        ]);

        $answer = $slide->answers()->create([
            'body' => 'This is the first answer',
            'is_correct' => true,
        ]);

        $answer = $slide->answers()->create([
            'body' => 'This is the second answer',
            'is_correct' => false,
        ]);

        $answer = $slide->answers()->create([
            'body' => 'This is the third answer',
            'is_correct' => false,
        ]);

        $answer = $slide->answers()->create([
            'body' => 'This is the fourth answer',
            'is_correct' => false,
        ]);

        $lesson2 = $section->lessons()->create([
            'title' => 'Introduction to PHP',
            'description' => 'This is the introduction to PHP lesson',
        ]);

        $lesson3 = $section->lessons()->create([
            'title' => 'Introduction to HTML',
            'description' => 'This is the introduction to HTML lesson',
        ]);

        //enroll student in course
        $student->enrollments()->create([
            'course_id' => $course->_id,
            'finished_lessons' => [$lesson2->_id],
        ]);

        //add streak and points to user
        $student->streaks()->create(
            [
                'course_id' => $course->_id,
            ]
        );

        $student->points = 10;
        $student->save();





        Tag::factory(10)->create();








    }
}
