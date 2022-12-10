<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateLessonDetailsTest extends TestCase
{
    public function test_teacher_update_lesson_details()
    {
        $user = User::factory()->create([
            'role' => 'teacher',
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

        $response = $this->actingAs($user)->post('/api/update-lesson-details/', [
            'lesson_id' => $lesson->_id,
            'title' => 'updated title',
            'description' => 'updated description',
            'order' => 1,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('lessons', [
            '_id' => $lesson->_id,
            'title' => 'updated title',
            'description' => 'updated description',
        ]);

    }
}
