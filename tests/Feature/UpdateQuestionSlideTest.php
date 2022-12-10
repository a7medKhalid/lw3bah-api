<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateQuestionSlideTest extends TestCase
{
    public function test_update_question_slide()
    {
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

        $slide = Slide::factory()->create([
            'lesson_id' => $lesson->_id,
            'type' => 'question',
            'question_type' => 'multipleChoice',
        ]);

        $response = $this->actingAs($user)->post('/api/update-question-slide', [
            'slide_id' => $slide->_id,
            'title' => 'What is the capital of France?',
            'answers' => [
                [
                    'body' => 'Paris',
                    'is_correct' => true,
                ],
                [
                    'body' => 'London',
                    'is_correct' => false,
                ],
                [
                    'body' => 'Berlin',
                    'is_correct' => false,
                ],
                [
                    'body' => 'Rome',
                    'is_correct' => false,
                ],
            ],
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('slides', [
            '_id' => $slide->_id,
            'title' => 'What is the capital of France?',
        ]);

        $this->assertDatabaseHas('answers', [
            'body' => 'Paris',
            'is_correct' => true,
        ]);

        $this->assertDatabaseHas('answers', [
            'body' => 'London',
            'is_correct' => false,
        ]);

        $this->assertDatabaseHas('answers', [
            'body' => 'Berlin',
            'is_correct' => false,
        ]);

        $this->assertDatabaseHas('answers', [
            'body' => 'Rome',
            'is_correct' => false,
        ]);


    }
}
