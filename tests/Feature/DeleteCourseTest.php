<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCourseTest extends TestCase
{
    public function test_delete_course()
    {
        $user = \App\Models\User::factory()->create([
            'role' => 'teacher',
        ]);
        $course = \App\Models\Course::factory()->create([
            'teacher_id' => $user->_id,
        ]);

        $response = $this->actingAs($user)->post('/api/delete-course', ['course_id' => $course->_id]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('courses', [
            '_id' => $course->_id,
        ]);
    }
}
