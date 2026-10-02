<?php

namespace Tests\Feature;

use App\Models\Serveuse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServeuseSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_search_for_serveuses(): void
    {
        $this->actingAs(User::factory()->create());
        Serveuse::create(['nom' => 'DJO Aminata']);

        $this->getJson('/api/serveuses/search?q=DJO')
            ->assertOk()
            ->assertJsonFragment(['nom' => 'DJO Aminata'])
            ->assertJsonPath('0.solde', 0);
    }
}