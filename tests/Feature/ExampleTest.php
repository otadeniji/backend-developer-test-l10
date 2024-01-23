<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchievementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the achievements endpoint for a user with no achievements.
     */
    public function test_achievements_for_new_user(): void
    {
        $user = User::factory()->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200)
                 ->assertJson([
                     'unlocked_achievements' => [],
                     'next_available_achievements' => ['First Lesson Watched', 'First Comment Written'],
                     'current_badge' => 'Beginner',
                     'next_badge' => 'Intermediate',
                     'remaining_to_unlock_next_badge' => 4
                 ]);
    }

    /**
     * Test the achievements endpoint for a user with some achievements.
     */
    public function test_achievements_for_user_with_progress(): void
    {
        $user = User::factory()->create();

        // Simulate user actions to unlock some achievements
        // ...

        $response = $this->get("/users/{$user->id}/achievements");

        // Adjust the expected response based on the simulated actions
        $response->assertStatus(200)
                 ->assertJson([
                     // Expected JSON structure based on user's progress
                 ]);
    }

    /**
     * Test the achievements endpoint for an invalid user.
     */
    public function test_achievements_for_invalid_user(): void
    {
        $response = $this->get("/users/invalid-user-id/achievements");

        $response->assertStatus(404); // Assuming invalid users return a 404
    }

    // Additional tests as needed...
}
