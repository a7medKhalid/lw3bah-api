<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateContentSLideTest extends TestCase
{
    public function test_teacher_can_update_content_slide()
    {
        $user = User::factory()->create([
            'role' => 'teacher',
        ]);

        $course = $user->courses()->create([
            'title' => 'test course',
            'description' => 'test course description',
        ]);

        $section = $course->sections()->create([
            'title' => 'test section',
            'description' => 'test section description',
        ]);

        $lesson = $section->lessons()->create([
            'title' => 'test lesson',
            'description' => 'test lesson description',
        ]);

        $slide = $lesson->slides()->create([
            'type' => 'content',
            'content_type' => 'text',
            'title' => 'test slide',
            'body' => 'test slide body',
            'order' => 1,
        ]);

        $response = $this->actingAs($user)->postJson('/api/update-content-slide', [
            'slide_id' => $slide->_id,
            'title' => 'updated slide title',
            'body' => 'updated slide body',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide->_id,
            'title' => 'updated slide title',
            'body' => 'updated slide body',
        ]);


    }

    public function test_teacher_can_update_media_slide(){
        $user = User::factory()->create([
            'role' => 'teacher',
        ]);

        $course = $user->courses()->create([
            'title' => 'test course',
            'description' => 'test course description',
        ]);

        $section = $course->sections()->create([
            'title' => 'test section',
            'description' => 'test section description',
        ]);

        $lesson = $section->lessons()->create([
            'title' => 'test lesson',
            'description' => 'test lesson description',
        ]);

        $slide = $lesson->slides()->create([
            'type' => 'text',
            'content_type' => 'mediaAndText',
            'title' => 'test slide',
            'body' => 'test slide body',
            'order' => 1,
        ]);

        $response = $this->actingAs($user)->postJson('/api/update-content-slide', [
            'slide_id' => $slide->_id,
            'media_type' => 'video',
            'media' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
            'body' => 'updated slide body',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide->_id,
            'body' => 'updated slide body',
        ]);

        $this->assertDatabaseHas('media', [
            'slide_id' => $slide->_id,
            'type' => 'video',
            'url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
        ]);
    }
}
