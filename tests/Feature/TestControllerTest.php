<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Result;
use App\Models\Question;
use App\Models\Option;
use App\Models\CategoryResult;
use App\Models\QuestionResult;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_method()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate request data
        $data = [
            'questions' => [1, 2, 3], // Example option IDs
            'aksi' => 'simpan',
        ];

        // Execute the store method
        $response = $this->post(route('test.store'), $data);

        // Assert the response
        $response->assertRedirect(route('survey.edit', Result::first()->id));
    }

    public function test_update_method()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate request data
        $data = [
            'questions' => [1, 2, 3], // Example option IDs
            'aksi' => 'simpan',
        ];

        // Create a result
        $result = Result::factory()->create(['user_id' => $user->id]);

        // Execute the update method
        $response = $this->put(route('test.update', $result->id), $data);

        // Assert the response
        $response->assertRedirect(route('client.test.edit', $result->id));
    }
}
