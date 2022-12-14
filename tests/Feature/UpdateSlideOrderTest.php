<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateSlideOrderTest extends TestCase
{

    public function test_update_slide_order(){
        $user = User::factory()->create([
            'role' => 'teacher'
        ]);

        $course = $user->courses()->create([
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

        $slide1 = $lesson->slides()->create([
            'title' => 'Test Slide 1',
            'description' => 'Test Description',
            'order' => 1,
        ]);

        $slide2 = $lesson->slides()->create([
            'title' => 'Test Slide 2',
            'description' => 'Test Description',
            'order' => 2,
        ]);

        $slide3 = $lesson->slides()->create([
            'title' => 'Test Slide 3',
            'description' => 'Test Description',
            'order' => 3,
        ]);

        $slide4 = $lesson->slides()->create([
            'title' => 'Test Slide 4',
            'description' => 'Test Description',
            'order' => 4,
        ]);

        $slide5 = $lesson->slides()->create([
            'title' => 'Test Slide 5',
            'description' => 'Test Description',
            'order' => 5,
        ]);

        $slide6 = $lesson->slides()->create([
            'title' => 'Test Slide 6',
            'description' => 'Test Description',
            'order' => 6,
        ]);

        $this->actingAs($user)->postJson('/api/update-slide-order', [
            'slide_id' => $slide1->_id,
            'order' => 3,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide1->_id,
            'order' => 3,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide2->_id,
            'order' => 1,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide3->_id,
            'order' => 2,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide4->_id,
            'order' => 4,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide5->_id,
            'order' => 5,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide6->_id,
            'order' => 6,
        ]);
    }

    public function test_update_slide_order_down()
    {
        $user = User::factory()->create([
            'role' => 'teacher'
        ]);

        $course = $user->courses()->create([
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

        $slide1 = $lesson->slides()->create([
            'title' => 'Test Slide 1',
            'description' => 'Test Description',
            'order' => 1,
        ]);

        $slide2 = $lesson->slides()->create([
            'title' => 'Test Slide 2',
            'description' => 'Test Description',
            'order' => 2,
        ]);

        $slide3 = $lesson->slides()->create([
            'title' => 'Test Slide 3',
            'description' => 'Test Description',
            'order' => 3,
        ]);

        $slide4 = $lesson->slides()->create([
            'title' => 'Test Slide 4',
            'description' => 'Test Description',
            'order' => 4,
        ]);

        $slide5 = $lesson->slides()->create([
            'title' => 'Test Slide 5',
            'description' => 'Test Description',
            'order' => 5,
        ]);

        $slide6 = $lesson->slides()->create([
            'title' => 'Test Slide 6',
            'description' => 'Test Description',
            'order' => 6,
        ]);

        $response = $this->actingAs($user)->postJson('/api/update-slide-order', [
            'slide_id' => $slide2->_id,
            'order' => 1,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide1->_id,
            'order' => 2,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide2->_id,
            'order' => 1,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide3->_id,
            'order' => 3,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide4->_id,
            'order' => 4,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide5->_id,
            'order' => 5,
        ]);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide6->_id,
            'order' => 6,
        ]);
    }


}
