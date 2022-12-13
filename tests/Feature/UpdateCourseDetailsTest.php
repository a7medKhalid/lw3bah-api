<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCourseDetailsTest extends TestCase
{
    public function test_update_course_details()
    {
       $user = User::factory()->create([
           'role' => 'teacher'
       ]);

     $course = $user->courses()->create([
          'title' => 'Test Course',
          'description' => 'Test Description',
     ]);

    $response = $this->actingAs($user)->post('api/update-course-details', [
         'course_id' => $course->_id,
         'title' => 'Updated Course Name',
         'description' => 'Updated Course Description',
            'tags' => ['tag1', 'tag2'],
     ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('courses', [
        '_id' => $course->_id,
        'title' => 'Updated Course Name',
        'description' => 'Updated Course Description',
    ]);

    }
}
