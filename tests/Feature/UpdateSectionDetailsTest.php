<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateSectionDetailsTest extends TestCase
{

    public function test_teacher_can_update_section_details()
    {
        $user = User::factory()->create([
            'role' => 'teacher'
        ]);

        $course = $user->courses()->create([
            'title' => 'course title',
            'description' => 'course description',
        ]);

        $section = $course->sections()->create([
            'title' => 'section title',
            'description' => 'section description',
            'order' => 1,
        ]);

        $response = $this->actingAs($user)->post('/api/update-section-details/', [
            'section_id' => $section->_id,
            'title' => 'new section title',
            'description' => 'new section description',
            'order' => 1,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('sections', [
            '_id' => $section->_id,
            'title' => 'new section title',
            'description' => 'new section description',
            'order' => 1,
        ]);


    }
}
