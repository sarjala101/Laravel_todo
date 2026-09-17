<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CheckEmailTest extends TestCase
{
    use DatabaseTransactions;

    public function test_check_email_returns_true_when_email_exists(): void
    {
        User::factory()->create([
            'email' => 'john@example.com',
        ]);

        $response = $this->postJson('/api/check-email', [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'exists' => true,
            ]);
    }

    public function test_check_email_returns_false_when_email_does_not_exist(): void
    {
        $response = $this->postJson('/api/check-email', [
            'email' => 'available@example.com',
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'exists' => false,
            ]);
    }

    public function test_check_email_validates_required_email(): void
    {
        $response = $this->postJson('/api/check-email', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_check_email_validates_email_format(): void
    {
        $response = $this->postJson('/api/check-email', [
            'email' => 'john',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
