<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteSlideTest extends TestCase
{
   public function test_delete_slide()
   {
       $user = \App\Models\User::factory()->create([
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

     $slide = $lesson->slides()->create([
          'type' => 'content',
          'content_type' => 'text',
          'order' => 1,
     ]);

        $response = $this->actingAs($user)->post('/api/delete-slide/', ['slide_id' => $slide->_id]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('slides', [
            '_id' => $slide->_id,
        ]);


   }
}
