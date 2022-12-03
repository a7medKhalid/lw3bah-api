<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateNewCourseTest extends TestCase
{
    public function test_teacher_can_create_course()
    {
        $user = User::factory()->create([
            'role' => 'teacher'
        ]);

        $response = $this->actingAs($user)->post('/api/create-new-course', [
            'title' => 'test title',
            'description' => 'test description',
        ]);

        $response->assertStatus(201);

        //assert database has new course

        $this->assertDatabaseHas('courses', [
            'title' => 'test title',
            'description' => 'test description',
        ]);


    }

    public function test_student_can_not_create_course()
    {
        $user = User::factory()->create([
            'role' => 'student'
        ]);

        $response = $this->actingAs($user)->post('/api/create-new-course', [
            'title' => 'test title',
            'description' => 'test description',
        ]);

        $response->assertStatus(403);

    }
}
