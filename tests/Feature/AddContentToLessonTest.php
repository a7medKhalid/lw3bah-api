<?php

namespace Tests\Feature;

use App\Enums\UserRoleEnum;
use App\Models\Course;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddContentToLessonTest extends TestCase
{
   public function test_teacher_can_add_content_to_lesson()
   {
       $user = User::factory()->create([
           'role' => UserRoleEnum::teacher
       ]);

       $course = Course::factory()->create([
           'teacher_id' => $user->id
       ]);

       $section = Section::factory()->create([
           'course_id' => $course->id
       ]);

       $lesson = $section->lessons()->create([
           'title' => 'Lesson 1',
           'description' => 'This is the first lesson',
           'section_id' => $section->id
       ]);


         $this->actingAs($user);

        $response = $this->post('/api/add-content-to-lesson', [
            'lesson_id' => $lesson->id,
            'type' => 'text',
            'order' => 1,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('slides', [
            'lesson_id' => $lesson->id,
            'content_type' => 'text',
            'order' => 1,
        ]);
   }
}
