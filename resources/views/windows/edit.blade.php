@extends('layouts.app')

@section('content')
<h1>Editar ventana</h1>
<form method="POST" action="{{ url('/windows/' . $window->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="proforma_id" class="form-label">Proforma</label>
        <select name="proforma_id" id="proforma_id" class="form-control" required>
            @foreach($proformas as $proforma)
                <option value="{{ $proforma->id }}" @if($window->proforma_id == $proforma->id) selected @endif>#{{ $proforma->id }} - {{ $proforma->fecha }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="product_id" class="form-label">Producto</label>
        <select name="product_id" id="product_id" class="form-control" required>
            @foreach($products as $product)
                <option value="{{ $product->id }}" @if($window->product_id == $product->id) selected @endif>{{ $product->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="alto" class="form-label">Alto (m)</label>
        <input type="number" step="0.01" name="alto" id="alto" class="form-control" value="{{ $window->alto }}" required>
    </div>
    <div class="mb-3">
        <label for="ancho" class="form-label">Ancho (m)</label>
        <input type="number" step="0.01" name="ancho" id="ancho" class="form-control" value="{{ $window->ancho }}" required>
    </div>
    <div class="mb-3">
        <label for="color_aluminio" class="form-label">Color aluminio</label>
        <input type="text" name="color_aluminio" id="color_aluminio" class="form-control" value="{{ $window->color_aluminio }}" required>
    </div>
    <div class="mb-3">
        <label for="color_vidrio" class="form-label">Color vidrio</label>
        <input type="text" name="color_vidrio" id="color_vidrio" class="form-control" value="{{ $window->color_vidrio }}" required>
    </div>
    <div class="mb-3">
        <label for="tipo_vidrio" class="form-label">Tipo vidrio</label>
        <input type="text" name="tipo_vidrio" id="tipo_vidrio" class="form-control" value="{{ $window->tipo_vidrio }}" required>
    </div>
    <div class="mb-3">
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" value="{{ $window->cantidad }}" required>
    </div>
    <h3>Materiales</h3>
    <div id="materiales-list">
        @foreach($materials as $material)
        <div class="mb-2">
            <label>{{ $material->nombre }} ({{ $material->color }}) - ${{ number_format($material->precio_pieza, 2) }} por pieza</label>
            <input type="number" name="materials[{{ $loop->index }}][material_id]" value="{{ $material->id }}" hidden>
            <input type="number" name="materials[{{ $loop->index }}][cantidad]" class="form-control d-inline-block w-auto" min="0" placeholder="Cantidad" value="{{ $window->materials->firstWhere('id', $material->id)?->pivot->cantidad ?? 0 }}">
        </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-primary">Actualizar ventana</button>
</form>
@endsection
@section('scripts')
<script>
    function calcularCosto() {
        let total = 0;
        @foreach($materials as $material)
            let cantidad = parseInt(document.querySelector('input[name="materials[{{ $loop->index }}][cantidad]"]').value) || 0;
            total += cantidad * {{ $material->precio_pieza }};
        @endforeach
        // Puedes mostrar el costo estimado aquí si lo deseas
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name^="materials"]').forEach(function(input) {
            input.addEventListener('input', calcularCosto);
        });
    });
</script>
@endsection
