<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cidade;

class CidadeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_can_list_all_cidades()
    {
        Cidade::factory()->count(5)->create();

        $response = $this->getJson('/api/cidade/getAll');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_it_can_get_a_city_by_id()
    {
        $cidade = Cidade::factory()->create();

        $response = $this->getJson("/api/cidade/get/{$cidade->codCidade}");

        $response->assertStatus(200);
        $response->assertJson([
            'codCidade' => $cidade->codCidade,
            'nomeCidade' => $cidade->nomeCidade,
        ]);
    }

    public function test_it_returns_404_if_city_not_found()
    {
        $response = $this->getJson('/api/cidade/get/9999');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Cidade não encontrada']);
    }

    public function test_it_can_register_a_city()
    {
        $data = ['nomeCidade' => $this->faker->city];

        $response = $this->postJson('/api/cidade/register', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('cidade', $data);
    }

    public function test_it_validates_city_registration()
    {
        $response = $this->postJson('/api/cidade/register', []);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['nomeCidade']);
    }

    public function test_it_can_update_a_city_by_id()
    {
        $cidade = Cidade::factory()->create();
        $newData = ['nomeCidade' => $this->faker->city];

        $response = $this->putJson("/api/cidade/edit/{$cidade->codCidade}", $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('cidade', $newData);
    }

    public function test_it_returns_404_if_city_not_found_for_update()
    {
        $data = ['nomeCidade' => $this->faker->city];

        $response = $this->putJson('/api/cidade/edit/9999', $data);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Cidade não encontrada']);
    }

    public function test_it_can_delete_a_city_by_id()
    {
        $cidade = Cidade::factory()->create();

        $response = $this->deleteJson("/api/cidade/delete/{$cidade->codCidade}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('cidade', ['codCidade' => $cidade->codCidade]);
    }

    public function test_it_returns_404_if_city_not_found_for_deletion()
    {
        $response = $this->deleteJson('/api/cidade/delete/9999');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Cidade não encontrada']);
    }
}
