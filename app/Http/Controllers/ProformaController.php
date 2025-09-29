<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use Illuminate\Http\Request;

class ProformaController extends Controller
{
    // ...existing code...

    public function index()
    {
        // Listar proformas del usuario autenticado
        $proformas = Proforma::where('user_id', auth()->id())
            ->with(['windows.materials'])
            ->get();
        return view('proformas.index', compact('proformas'));
    }

    public function show($id)
    {
        // Mostrar detalle de una proforma del usuario
        $proforma = Proforma::where('user_id', auth()->id())
            ->with(['windows.materials'])
            ->findOrFail($id);
        return view('proformas.show', compact('proforma'));
    }
}