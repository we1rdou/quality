<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Material;
use App\Models\Proforma;
use App\Models\Window;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // Obtener usuario actual (o el primero)
        $user = User::first();

        // Crear producto
        $productoVentana = Product::firstOrCreate([
            'nombre' => 'Ventana',
            'descripcion' => 'Ventana de aluminio y vidrio',
            'activo' => true,
        ]);

        // Crear materiales
        $aluminio = Material::firstOrCreate([
            'nombre' => 'Aluminio',
            'tipo' => 'Perfil',
            'descripcion' => 'Perfil de aluminio',
            'longitud_pieza' => 6.0,
            'precio_pieza' => 25.00,
            'unidad' => 'm',
            'color' => 'Blanco',
        ]);
        $vidrio = Material::firstOrCreate([
            'nombre' => 'Vidrio',
            'tipo' => 'Panel',
            'descripcion' => 'Vidrio templado', 
            'longitud_pieza' => 2.0,
            'precio_pieza' => 40.00,
            'unidad' => 'm2',
            'color' => 'Transparente',
        ]);

        // Crear proforma para el usuario
        $proforma = Proforma::firstOrCreate([
            'user_id' => $user->id,
            'fecha' => now()->toDateString(),
            'total' => 0,
        ]);

        // Crear ventana asociada a la proforma
        $ventana = Window::create([
            'proforma_id' => $proforma->id,
            'product_id' => $productoVentana->id,
            'alto' => 120,
            'ancho' => 100,
            'color_aluminio' => 'Blanco',
            'color_vidrio' => 'Transparente',
            'tipo_vidrio' => 'Templado',
            'cantidad' => 2,
            'precio_total' => 150.00,
        ]);

        // Asociar materiales a la ventana
        $ventana->materials()->attach($aluminio->id, ['cantidad' => 4]);
        $ventana->materials()->attach($vidrio->id, ['cantidad' => 2]);

        // Actualizar total de la proforma
        $proforma->total = $ventana->precio_total * $ventana->cantidad;
        $proforma->save();
    }
}
