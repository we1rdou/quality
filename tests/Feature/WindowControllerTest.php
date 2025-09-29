<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Proforma;
use App\Models\Material;
use App\Models\User;

class WindowControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_window_with_materials()
    {
        $user = User::factory()->create();
        $proforma = Proforma::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $material = Material::factory()->create(['precio_pieza' => 10]);

        $response = $this->post('/windows', [
            'proforma_id' => $proforma->id,
            'product_id' => $product->id,
            'alto' => 1.5,
            'ancho' => 1.2,
            'color_aluminio' => 'Blanco',
            'color_vidrio' => 'Transparente',
            'tipo_vidrio' => 'Templado',
            'cantidad' => 2,
            'materials' => [
                ['material_id' => $material->id, 'cantidad' => 3],
            ],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('windows', [
            'proforma_id' => $proforma->id,
            'product_id' => $product->id,
            'precio_total' => 30, // 10 * 3
        ]);
        $this->assertDatabaseHas('material_window', [
            'material_id' => $material->id,
            'cantidad' => 3,
        ]);
    }

    public function test_store_window_with_multiple_materials()
    {
        $user = User::factory()->create();
        $proforma = Proforma::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $mat1 = Material::factory()->create(['precio_pieza' => 10]);
        $mat2 = Material::factory()->create(['precio_pieza' => 5]);

        $response = $this->post('/windows', [
            'proforma_id' => $proforma->id,
            'product_id' => $product->id,
            'alto' => 2.0,
            'ancho' => 1.0,
            'color_aluminio' => 'Negro',
            'color_vidrio' => 'Azul',
            'tipo_vidrio' => 'Laminado',
            'cantidad' => 1,
            'materials' => [
                ['material_id' => $mat1->id, 'cantidad' => 2],
                ['material_id' => $mat2->id, 'cantidad' => 4],
            ],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('windows', [
            'proforma_id' => $proforma->id,
            'product_id' => $product->id,
            'precio_total' => 10*2 + 5*4, // 20 + 20 = 40
        ]);
        $this->assertDatabaseHas('material_window', [
            'material_id' => $mat1->id,
            'cantidad' => 2,
        ]);
        $this->assertDatabaseHas('material_window', [
            'material_id' => $mat2->id,
            'cantidad' => 4,
        ]);
    }

    public function test_store_window_with_invalid_material_id()
    {
        $user = User::factory()->create();
        $proforma = Proforma::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $mat1 = Material::factory()->create(['precio_pieza' => 10]);
        $invalidId = 9999;

        $response = $this->post('/windows', [
            'proforma_id' => $proforma->id,
            'product_id' => $product->id,
            'alto' => 1.0,
            'ancho' => 1.0,
            'color_aluminio' => 'Negro',
            'color_vidrio' => 'Azul',
            'tipo_vidrio' => 'Laminado',
            'cantidad' => 1,
            'materials' => [
                ['material_id' => $mat1->id, 'cantidad' => 2],
                ['material_id' => $invalidId, 'cantidad' => 1],
            ],
        ]);

        $response->assertStatus(302); // Redirección por error de validación
        $response->assertSessionHasErrors(['materials.1.material_id']);
    }

    public function test_store_window_missing_required_fields()
    {
        $response = $this->post('/windows', [
            // Falta proforma_id, product_id, alto, ancho, etc.
            'materials' => [],
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'proforma_id', 'product_id', 'alto', 'ancho', 'color_aluminio', 'color_vidrio', 'tipo_vidrio', 'cantidad', 'materials'
        ]);
    }

    public function test_store_window_with_zero_or_negative_quantity()
    {
        $user = User::factory()->create();
        $proforma = Proforma::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $mat1 = Material::factory()->create(['precio_pieza' => 10]);

        $response = $this->post('/windows', [
            'proforma_id' => $proforma->id,
            'product_id' => $product->id,
            'alto' => 1.0,
            'ancho' => 1.0,
            'color_aluminio' => 'Negro',
            'color_vidrio' => 'Azul',
            'tipo_vidrio' => 'Laminado',
            'cantidad' => 0,
            'materials' => [
                ['material_id' => $mat1->id, 'cantidad' => -1],
            ],
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['cantidad', 'materials.0.cantidad']);
    }

    public function test_store_window_with_large_numbers()
    {
        $user = User::factory()->create();
        $proforma = Proforma::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $mat1 = Material::factory()->create(['precio_pieza' => 1000]);
        $mat2 = Material::factory()->create(['precio_pieza' => 500]);

        $response = $this->post('/windows', [
            'proforma_id' => $proforma->id,
            'product_id' => $product->id,
            'alto' => 10.0,
            'ancho' => 5.0,
            'color_aluminio' => 'Oro',
            'color_vidrio' => 'Diamante',
            'tipo_vidrio' => 'Blindado',
            'cantidad' => 100,
            'materials' => [
                ['material_id' => $mat1->id, 'cantidad' => 100],
                ['material_id' => $mat2->id, 'cantidad' => 200],
            ],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('windows', [
            'proforma_id' => $proforma->id,
            'product_id' => $product->id,
            'precio_total' => 1000*100 + 500*200, // 100000 + 100000 = 200000
        ]);
    }
}
