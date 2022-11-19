<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_dashboard()
    {
        $user = User::factory()->make();

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200);
    }
}
