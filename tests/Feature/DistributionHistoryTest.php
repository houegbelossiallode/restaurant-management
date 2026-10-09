<?php

namespace Tests\Feature;

use App\Models\Boisson;
use App\Models\Distribution;
use App\Models\Serveuse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistributionHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_filter_distribution_history_by_serveuse_or_boisson(): void
    {
        $this->actingAs(User::factory()->create());

        $this->createDistribution('Aminata DJO', 'EKU');
        $this->createDistribution('Binta KONE', 'Jus');

        $this->get(route('distributions.index', ['search' => 'Aminata']))
            ->assertOk()
            ->assertSee('Aminata DJO')
            ->assertSee('EKU')
            ->assertDontSee('Binta KONE');

        $this->get(route('distributions.index', ['search' => 'Jus']))
            ->assertOk()
            ->assertSee('Binta KONE')
            ->assertSee('Jus')
            ->assertDontSee('Aminata DJO');
    }

    public function test_authenticated_user_can_export_distribution_history_to_excel_and_pdf(): void
    {
        $this->actingAs(User::factory()->create());
        $this->createDistribution('Aminata DJO', 'EKU');

        $this->get(route('distributions.export.excel', ['search' => 'Aminata']))
            ->assertOk()
            ->assertHeader('content-disposition');

        $this->get(route('distributions.export.pdf', ['search' => 'Aminata']))
            ->assertOk()
            ->assertHeader('content-disposition');
    }

    private function createDistribution(string $serveuseName, string $boissonName): void
    {
        $serveuse = Serveuse::create(['nom' => $serveuseName]);
        $boisson = Boisson::create(['nom' => $boissonName, 'prix_unitaire' => 350]);

        Distribution::create([
            'serveuse_id' => $serveuse->id,
            'boisson_id' => $boisson->id,
            'quantite' => 2,
            'prix_unitaire' => 350,
            'montant_total' => 700,
            'date_distribution' => now(),
        ]);
    }
}