<?php
namespace App\Http\Controllers;

use App\Models\Window;
use App\Models\Material;
use App\Models\Product;
use App\Models\Proforma;
use Illuminate\Http\Request;

class WindowController extends Controller
{
    // Mostrar el formulario para crear una nueva ventana
    public function create()
    {
        $products = Product::where('activo', true)->get();
        $materials = Material::all();
        $proformas = Proforma::where('user_id', request()->user()->id)->get();
        return view('windows.create', compact('products', 'materials', 'proformas'));
    }

    // Registrar una ventana y asociar materiales
    public function store(Request $request)
    {
        $validated = $request->validate([
            'proforma_id' => 'nullable|exists:proformas,id',
            'product_id' => 'required|exists:products,id',
            'alto' => 'required|numeric|min:0.1',
            'ancho' => 'required|numeric|min:0.1',
            'color_aluminio' => 'required|string',
            'color_vidrio' => 'required|string',
            'tipo_vidrio' => 'required|string',
            'cantidad' => 'required|integer|min:1',
            // Elimina la validación de materials
        ]);

        // Calcular materiales y costo automáticamente
        $alto = $validated['alto'];
        $ancho = $validated['ancho'];
        $cantidad = $validated['cantidad'];

        // Ejemplo de cálculo: perímetro para aluminio, área para vidrio
        $aluminio = Material::where('nombre', 'Aluminio')->first();
        $vidrio = Material::where('nombre', 'Vidrio')->first();
        $cantAluminio = ($alto * 2 + $ancho * 2) * $cantidad; // metros lineales
        $cantVidrio = ($alto * $ancho) * $cantidad; // m2
        $totalMateriales = 0;
        if ($aluminio) {
            $totalMateriales += $aluminio->precio_pieza * ceil($cantAluminio / $aluminio->longitud_pieza);
        }
        if ($vidrio) {
            $totalMateriales += $vidrio->precio_pieza * ceil($cantVidrio / $vidrio->longitud_pieza);
        }

        // Si no se seleccionó proforma, crear una nueva
        if (empty($validated['proforma_id'])) {
            $proforma = Proforma::create([
                'user_id' => $request->user()->id,
                'fecha' => now()->toDateString(),
                'total' => 0,
            ]);
            $validated['proforma_id'] = $proforma->id;
        }

        // Crear la ventana con precio_total calculado
        $window = Window::create(array_merge(
            $validated,
            ['precio_total' => $totalMateriales]
        ));

        // Asociar materiales y cantidades calculadas
        if ($aluminio) {
            $window->materials()->attach($aluminio->id, ['cantidad' => ceil($cantAluminio / $aluminio->longitud_pieza)]);
        }
        if ($vidrio) {
            $window->materials()->attach($vidrio->id, ['cantidad' => ceil($cantVidrio / $vidrio->longitud_pieza)]);
        }

        // Actualizar total de la proforma sumando el precio_total de todas sus ventanas
        $proforma = Proforma::find($validated['proforma_id']);
        $proforma->total = $proforma->windows()->sum('precio_total');
        $proforma->save();

        return response()->json($window);
    }

    // Mostrar el formulario para editar una ventana existente
    public function edit($id)
    {
        $window = Window::with('materials')->findOrFail($id);
        $products = Product::where('activo', true)->get();
        $materials = Material::all();
        $proformas = Proforma::where('user_id', request()->user()->id)->get();
        return view('windows.edit', compact('window', 'products', 'materials', 'proformas'));
    }

    // Actualizar una ventana existente y sus materiales
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'proforma_id' => 'required|exists:proformas,id',
            'product_id' => 'required|exists:products,id',
            'alto' => 'required|numeric|min:0.1',
            'ancho' => 'required|numeric|min:0.1',
            'color_aluminio' => 'required|string',
            'color_vidrio' => 'required|string',
            'tipo_vidrio' => 'required|string',
            'cantidad' => 'required|integer|min:1',
            // Elimina la validación de materials
        ]);

        $window = Window::findOrFail($id);
        $window->update(collect($validated)->except('materials')->toArray());

        // Actualizar materiales
        $syncData = [];
        foreach ($validated['materials'] as $mat) {
            $syncData[$mat['material_id']] = ['cantidad' => $mat['cantidad']];
        }
        $window->materials()->sync($syncData);

        // Recalcular precio_total
        $totalMateriales = 0;
        foreach ($validated['materials'] as $mat) {
            $material = Material::find($mat['material_id']);
            if ($material) {
                $totalMateriales += $material->precio_pieza * $mat['cantidad'];
            }
        }
        $window->update(['precio_total' => $totalMateriales]);

        return redirect()->route('proformas.show', $window->proforma_id)->with('success', 'Ventana actualizada correctamente');
    }

    public function destroy($id)
    {
        $window = Window::findOrFail($id);
        $proformaId = $window->proforma_id;
        $window->materials()->detach();
        $window->delete();
        return redirect()->route('proformas.show', $proformaId)->with('success', 'Ventana eliminada correctamente');
    }
}
