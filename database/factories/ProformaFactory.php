<?php
namespace Database\Factories;

use App\Models\Proforma;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProformaFactory extends Factory
{
    protected $model = Proforma::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'fecha' => $this->faker->date(),
            'total' => 0,
            'pdf_path' => null,
        ];
    }
}
