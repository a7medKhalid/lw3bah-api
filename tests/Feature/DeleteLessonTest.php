<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteLessonTest extends TestCase
{

    public function test_delete_lesson(){
        $user = User::factory()->create([
            'role' => 'teacher',
        ]);

        $course = Course::factory()->create([
            'teacher_id' => $user->_id,
        ]);

        $section = Section::factory()->create([
            'course_id' => $course->_id,
        ]);

        $lesson = Lesson::factory()->create([
            'section_id' => $section->_id,
        ]);

        $response = $this->actingAs($user)->post('/api/delete-lesson', [
            'lesson_id' => $lesson->_id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('lessons', [
            '_id' => $lesson->_id,
        ]);
    }
}
