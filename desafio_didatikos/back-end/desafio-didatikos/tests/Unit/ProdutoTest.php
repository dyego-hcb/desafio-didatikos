<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Produto;
use App\Models\Marca;
use App\Models\Cidade;

class ProdutoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_can_list_all_produtos()
    {
        Produto::factory()->count(5)->create();

        $response = $this->getJson('/api/produtos/getAll');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_it_can_get_a_product_by_id()
    {
        $produto = Produto::factory()->create();

        $response = $this->getJson("/api/produtos/get/{$produto->codProduto}");

        $response->assertStatus(200);
        $response->assertJson([
            'codProduto' => $produto->codProduto,
            'nomeProduto' => $produto->nomeProduto,
        ]);
    }

    public function test_it_returns_404_if_product_not_found()
    {
        $response = $this->getJson('/api/produtos/get/9999');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Produto não encontrado']);
    }

    public function test_it_can_register_a_product()
    {
        $marca = Marca::factory()->create();
        $cidade = Cidade::factory()->create();

        $data = [
            'nomeProduto' => $this->faker->word(),
            'valorProduto' => $this->faker->randomFloat(2, 10, 1000),
            'marcaProduto' => $marca->codMarca,
            'estoque' => $this->faker->numberBetween(0, 500),
            'cidade' => $cidade->codCidade,
        ];

        $response = $this->postJson('/api/produtos/register', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('produto', $data);
    }

    public function test_it_validates_product_registration()
    {
        $response = $this->postJson('/api/produtos/register', []);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['nomeProduto', 'valorProduto', 'marcaProduto', 'estoque', 'cidade']);
    }

    public function test_it_can_update_a_product_by_id()
    {
        $produto = Produto::factory()->create();
        $newData = [
            'nomeProduto' => $this->faker->word(),
            'valorProduto' => $this->faker->randomFloat(2, 10, 1000),
            'marcaProduto' => Marca::factory()->create()->codMarca,
            'estoque' => $this->faker->numberBetween(0, 500),
            'cidade' => Cidade::factory()->create()->codCidade,
        ];

        $response = $this->putJson("/api/produtos/edit/{$produto->codProduto}", $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('produto', $newData);
    }

    public function test_it_returns_404_if_product_not_found_for_update()
    {
        $data = [
            'nomeProduto' => $this->faker->word(),
            'valorProduto' => $this->faker->randomFloat(2, 10, 1000),
            'marcaProduto' => Marca::factory()->create()->codMarca,
            'estoque' => $this->faker->numberBetween(0, 500),
            'cidade' => Cidade::factory()->create()->codCidade,
        ];

        $response = $this->putJson('/api/produtos/edit/9999', $data);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Produto não encontrado']);
    }

    public function test_it_can_delete_a_product_by_id()
    {
        $produto = Produto::factory()->create();

        $response = $this->deleteJson("/api/produtos/delete/{$produto->codProduto}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('produto', ['codProduto' => $produto->codProduto]);
    }

    public function test_it_returns_404_if_product_not_found_for_deletion()
    {
        $response = $this->deleteJson('/api/produtos/delete/9999');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Produto não encontrado']);
    }
}
