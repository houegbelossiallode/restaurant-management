<?php

namespace Tests\Feature;

use App\Models\Serveuse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServeuseDebtSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_filter_the_debts_page_by_serveuse_name(): void
    {
        $this->actingAs(User::factory()->create());
        Serveuse::create(['nom' => 'Aminata DJO']);
        Serveuse::create(['nom' => 'Binta KONE']);

        $this->get(route('serveuses.dettes', ['search' => 'Aminata']))
            ->assertOk()
            ->assertSee('Aminata DJO')
            ->assertDontSee('Binta KONE')
            ->assertSee('value="Aminata"', false);
    }

    public function test_debts_page_displays_an_empty_state_when_search_has_no_match(): void
    {
        $this->actingAs(User::factory()->create());
        Serveuse::create(['nom' => 'Aminata DJO']);

        $this->get(route('serveuses.dettes', ['search' => 'Inconnue']))
            ->assertOk()
            ->assertSee('Aucune serveuse ne correspond à cette recherche.');
    }
}