<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Marca;

class MarcaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_list_all_marcas()
    {
        Marca::factory()->count(5)->create();

        $response = $this->getJson('/api/marca/getAll');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_can_get_a_marca_by_id()
    {
        $marca = Marca::factory()->create();

        $response = $this->getJson("/api/marca/get/{$marca->codMarca}");

        $response->assertStatus(200);
        $response->assertJson([
            'codMarca' => $marca->codMarca,
            'nomeMarca' => $marca->nomeMarca,
        ]);
    }

    public function test_returns_404_if_marca_not_found()
    {
        $response = $this->getJson('/api/marca/get/9999');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Marca não encontrada']);
    }

    public function test_can_register_a_marca()
    {
        $data = ['nomeMarca' => $this->faker->company, 'fabricante' => $this->faker->company];

        $response = $this->postJson('/api/marca/register', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('marca', $data);
    }

    public function test_validates_marca_registration()
    {
        $response = $this->postJson('/api/marca/register', []);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['nomeMarca', 'fabricante']);
    }

    public function test_can_update_a_marca_by_id()
    {
        $marca = Marca::factory()->create();
        $newData = ['nomeMarca' => $this->faker->company, 'fabricante' => $this->faker->company];

        $response = $this->putJson("/api/marca/edit/{$marca->codMarca}", $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('marca', $newData);
    }

    public function test_returns_404_if_marca_not_found_for_update()
    {
        $data = ['nomeMarca' => $this->faker->company, 'fabricante' => $this->faker->company];

        $response = $this->putJson('/api/marca/edit/9999', $data);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Marca não encontrada']);
    }

    public function test_can_delete_a_marca_by_id()
    {
        $marca = Marca::factory()->create();

        $response = $this->deleteJson("/api/marca/delete/{$marca->codMarca}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('marca', ['codMarca' => $marca->codMarca]);
    }

    public function test_returns_404_if_marca_not_found_for_deletion()
    {
        $response = $this->deleteJson('/api/marca/delete/9999');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Marca não encontrada']);
    }
}
