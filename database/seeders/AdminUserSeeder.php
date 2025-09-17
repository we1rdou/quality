<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador por defecto si no existe
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@quality.com')],
            [
                'name' => env('ADMIN_NAME', 'Administrador'),
                'email' => env('ADMIN_EMAIL', 'admin@quality.com'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
                'phone' => env('ADMIN_PHONE', '+593987654321'),
                'address' => env('ADMIN_ADDRESS', 'Av. Principal 123'),
                'province' => env('ADMIN_PROVINCE', 'Guayas'),
                'city' => env('ADMIN_CITY', 'Guayaquil'),
                'role' => User::ROLE_ADMIN,
                'email_verified_at' => now(),
            ]
        );
    }
}
