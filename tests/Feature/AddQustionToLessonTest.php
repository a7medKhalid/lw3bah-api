<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddQustionToLessonTest extends TestCase
{
    public function test_teacher_can_add_question_to_lesson()
    {
        $user = User::factory()->create([
            'role' => 'teacher'
        ]);

        $course = $user->courses()->create([
            'title' => 'test course',
            'description' => 'test description',
        ]);

        $section = $course->sections()->create([
            'title' => 'test section',
            'description' => 'test description',
        ]);

        $lesson = $section->lessons()->create([
            'title' => 'test lesson',
            'description' => 'test description',
        ]);

        $response = $this->actingAs($user)->postJson('/api/add-question-to-lesson', [
            'lesson_id' => $lesson->_id,
            'type' => 'multipleChoice',
            'order' => 1,
        ]);


        $response->assertStatus(201);

        $this->assertDatabaseHas('slides', [
            'type' => 'question',
            'lesson_id' => $lesson->_id,
            'question_type' => 'multipleChoice',
            'order' => 1,
        ]);
    }
}
