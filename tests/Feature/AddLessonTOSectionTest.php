<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddLessonTOSectionTest extends TestCase
{
    public function test_teacher_can_add_lesson_to_section()
    {

        $user = User::factory()->create([
            'role' => 'teacher',
        ]);

        $course = Course::factory()->create([
            'title' => 'test course',
            'description' => 'test description',
            'teacher_id' => $user->_id,
        ]);

        $section = Section::factory()->create([
            'title' => 'section title',
            'course_id' => $course->_id,
        ]);

        $this->actingAs($user);


        $response = $this->post('/api/add-lesson-to-section', [
            'section_id' => $section->_id,
            'title' => 'Lesson 1',
            'description' => 'Description 1',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('lessons', [
            'title' => 'Lesson 1',
            'description' => 'Description 1',
            'section_id' => $section->_id,
        ]);
    }

    public function test_non_course_owner_cannot_add_lesson(){
        $user = User::factory()->create(
            [
                'role' => 'teacher'
            ]
        );

        $course = Course::factory()->create([
            'title' => 'test course',
            'description' => 'test description',
        ]);

        $this->actingAs($user);

        $section = Section::factory()->create([
            'title' => 'section title',
            'course_id' => $course->_id,
        ]);

        $response = $this->post('/api/add-lesson-to-section', [
            'section_id' => $section->_id,
            'title' => 'Lesson 1',
            'description' => 'Description 1',
        ]);

        $response->assertStatus(403);

    }
}
