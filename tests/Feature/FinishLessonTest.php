<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FinishLessonTest extends TestCase
{

    public function test_finish_lesson(){
        $teacher = User::factory()->create([
            'role' => 'teacher'
        ]);
        $student = User::factory()->create([
            'role' => 'student'
        ]);

        $course = $teacher->courses()->create([
            'title' => 'Test Course',
            'description' => 'Test Description',
        ]);

        $section = $course->sections()->create([
            'title' => 'Test Section',
            'description' => 'Test Description',
        ]);

        $lesson = $section->lessons()->create([
            'title' => 'Test Lesson',
            'description' => 'Test Description',
        ]);

        $lesson->slides()->create([
            'title' => 'Test Slide',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'order' => 1,
        ]);

        $lesson->slides()->create([
            'title' => 'Test Slide',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'order' => 2,
        ]);

        $response = $this->actingAs($student)->postJson('/api/finish-lesson', [
            'lesson_id' => $lesson->_id,
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'finished_lessons' => [$lesson->_id],
            'finished_sections' => [$section->_id],
            'is_finished' => true,
        ]);

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->_id,
            'course_id' => $course->_id,
            'finished_lessons' => [$lesson->_id],
            'finished_sections' => [$section->_id],
            'is_finished' => true,
        ]);

        $this->assertDatabaseHas('users', [
            '_id' => $student->_id,
            'points' => 10,
        ]);

        $this->assertDatabaseHas('streaks', [
            'user_id' => $student->_id,
            'course_id' => $course->_id,
        ]);
    }
}
