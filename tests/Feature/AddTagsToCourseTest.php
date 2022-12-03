<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddTagsToCourseTest extends TestCase
{
public function test_teacher_can_add_tags_to_course()
    {
        $user = User::factory()->create([
            'role' => 'teacher',
        ]);

        $course = Course::factory()->create([
            'user_id' => $user->_id,
        ]);


        $response = $this->actingAs($user)->post('/api/add-tags-to-course', [
            'course_id' => $course->_id,
            'tags' => ['tag1', 'tag2']
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tags', [
            'name' => 'tag1',
            'times_used' => 1,
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'tag2',
            'times_used' => 1,
        ]);

    }

    public function test_student_can_not_add_tags_to_course()
    {
        $user = User::factory()->create([
            'role' => 'student',
        ]);
        $course = Course::factory()->create();

        $response = $this->actingAs($user)->post('/api/add-tags-to-course', [
            'course_id' => $course->id,
            'tags' => ['tag1', 'tag2']
        ]);

        $response->assertStatus(403);
    }
}
