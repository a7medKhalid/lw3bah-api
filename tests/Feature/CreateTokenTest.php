<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTokenTest extends TestCase
{
    public function test_create_token()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/create-token', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'test device',
        ]);
        $response->assertStatus(201);
        $this->assertNotNull($response['token']);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'test device',
        ]);
    }


}
