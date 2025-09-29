<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proforma;
use App\Models\User;

class ProformaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();
        Proforma::factory()->count(5)->create(['user_id' => $user->id]);
    }
}
