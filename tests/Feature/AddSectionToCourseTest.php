<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddSectionToCourseTest extends TestCase
{

    public function test_add_section_to_course()
   {

       $user = User::factory()->create(
              [
                'role' => 'teacher'
              ]
         );

       $course = Course::factory()->create([
              'teacher_id' => $user->_id,
       ]);

       $this->actingAs($user);

       $response = $this->post('/api/add-section-to-course', [
           'course_id' => $course->_id,
           'title' => 'Section 1',
       ]);

       $response->assertStatus(200);

       $this->assertDatabaseHas('sections', [
           'title' => 'Section 1',
       ]);
   }

   public function test_non_course_course_owner_can_not_add_section_to_course()
   {
       $user = User::factory()->create(
              [
                'role' => 'teacher'
              ]
         );

       $course = Course::factory()->create();

       $this->actingAs($user);

       $response = $this->post('/api/add-section-to-course', [
           'course_id' => $course->_id,
           'title' => 'Section 1',
       ]);

       $response->assertStatus(403);
   }
}
