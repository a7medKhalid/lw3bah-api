<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnEnrollFromCourseTest extends TestCase
{

    public function test_unenroll_from_course(){
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

        $this->actingAs($student)->postJson('/api/finish-lesson', [
            'lesson_id' => $lesson->_id,
        ]);

        $response = $this->actingAs($student)->post('/api/unenroll-from-course', [
            'course_id' => $course->_id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->_id,
            'course_id' => $course->_id,
            'is_valid' => false,
        ]);
    }
}
