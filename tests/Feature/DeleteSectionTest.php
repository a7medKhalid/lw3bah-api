<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteSectionTest extends TestCase
{

    public function test_delete_section()
    {
        $user = User::factory()->create([
            'role' => 'teacher',
        ]);

        $course = $user->courses()->create([
            'name' => 'test course',
        ]);

        $section = $course->sections()->create([
            'name' => 'test section',
        ]);

        $response = $this->actingAs($user)->post('/api/delete-section/', [
            'section_id' => $section->_id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('sections', [
            '_id' => $section->_id,
        ]);
    }
}
