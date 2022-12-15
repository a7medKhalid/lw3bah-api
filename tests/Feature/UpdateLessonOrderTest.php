<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateLessonOrderTest extends TestCase
{
    public function test_update_lesson_order()
    {
        $user = User::factory()->create([
            'role' => 'teacher'
        ]);

        $course = $user->courses()->create([
            'title' => 'Test Course',
            'description' => 'Test Description',
            'image' => 'test.jpg',
            'price' => 100,
            'published' => true,
        ]);

        $section = $course->sections()->create([
            'title' => 'Test Section',
            'description' => 'Test Description',
            'order' => 1,
        ]);

        $lesson1 = $section->lessons()->create([
            'title' => 'Test Lesson 1',
            'description' => 'Test Description',
            'order' => 1,
        ]);

        $lesson2 = $section->lessons()->create([
            'title' => 'Test Lesson 2',
            'description' => 'Test Description',
            'order' => 2,
        ]);

        $lesson3 = $section->lessons()->create([
            'title' => 'Test Lesson 3',
            'description' => 'Test Description',
            'order' => 3,
        ]);

        $response = $this->actingAs($user)->post('/api/update-lesson-order', [
            'lesson_id' => $lesson2->_id,
            'order' => 1,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('lessons', [
            '_id' => $lesson2->_id,
            'order' => 1,
        ]);

        $this->assertDatabaseHas('lessons', [
            '_id' => $lesson1->_id,
            'order' => 2,
        ]);

        $this->assertDatabaseHas('lessons', [
            '_id' => $lesson3->_id,
            'order' => 3,
        ]);



    }
}
