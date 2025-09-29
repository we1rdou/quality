<?php
namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'tipo' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'longitud_pieza' => $this->faker->randomFloat(2, 0.5, 6),
            'precio_pieza' => $this->faker->randomFloat(2, 1, 100),
            'unidad' => 'm',
            'color' => $this->faker->safeColorName(),
        ];
    }
}
