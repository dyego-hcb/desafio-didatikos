<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// MODEL

use App\Models\Marca;
use App\Models\Cidade;
use App\Models\Produto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    protected $model = Produto::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomeProduto' => $this->faker->word(),
            'valorProduto' => $this->faker->randomFloat(2, 10, 1000),
            'marcaProduto' => Marca::factory(),
            'estoque' => $this->faker->numberBetween(0, 500),
            'cidade' => Cidade::factory(),
        ];
    }
}
