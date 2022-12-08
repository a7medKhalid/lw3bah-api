<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublishCourseTest extends TestCase
{
    public function test_teacher_can_publish_course(){
        //create teacher
        $teacher = User::factory()->create(['role' => 'teacher']);

        //create course
        $course = Course::factory()->create([
            'teacher_id' => $teacher->_id,
        ]);

        //publish course
        $response = $this->actingAs($teacher)->post('/api/publish-course', [
            'course_id' => $course->_id,
            'publish' => true,
        ]);

        $response->assertStatus(200);

        //assert course is published
        $this->assertDatabaseHas('courses', [
            '_id' => $course->_id,
            'is_published' => true,
        ]);
    }

}
