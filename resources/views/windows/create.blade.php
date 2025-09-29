@extends('layouts.app')

@section('content')
<h1>Crear nueva ventana</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $base = request()->get('base') == 1;
@endphp

<form method="POST" action="{{ url('/windows') }}">
    @csrf
    <div class="mb-3">
        <label for="proforma_id" class="form-label">Proforma</label>
        <select name="proforma_id" id="proforma_id" class="form-control">
            <option value="">Crear nueva proforma</option>
            @foreach($proformas as $proforma)
                <option value="{{ $proforma->id }}">#{{ $proforma->id }} - {{ $proforma->fecha }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="product_id" class="form-label">Producto</label>
        <select name="product_id" id="product_id" class="form-control" required>
            <option value="">Selecciona un producto</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="alto" class="form-label">Alto (m)</label>
        <input type="number" step="0.01" name="alto" id="alto" class="form-control" required value="{{ old('alto', $base ? 1 : '') }}">
    </div>
    <div class="mb-3">
        <label for="ancho" class="form-label">Ancho (m)</label>
        <input type="number" step="0.01" name="ancho" id="ancho" class="form-control" required value="{{ old('ancho', $base ? 1 : '') }}">
    </div>
    <div class="mb-3">
        <label for="color_aluminio" class="form-label">Color aluminio</label>
        <input type="text" name="color_aluminio" id="color_aluminio" class="form-control" required value="{{ old('color_aluminio', $base ? 'Blanco' : '') }}">
    </div>
    <div class="mb-3">
        <label for="color_vidrio" class="form-label">Color vidrio</label>
        <input type="text" name="color_vidrio" id="color_vidrio" class="form-control" required value="{{ old('color_vidrio', $base ? 'Transparente' : '') }}">
    </div>
    <div class="mb-3">
        <label for="tipo_vidrio" class="form-label">Tipo vidrio</label>
        <input type="text" name="tipo_vidrio" id="tipo_vidrio" class="form-control" required value="{{ old('tipo_vidrio', $base ? 'Templado' : '') }}">
    </div>
    <div class="mb-3">
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
    </div>
    <h3>Materiales</h3>
    <div id="materiales-list">
        @foreach($materials as $material)
        <div class="mb-2">
            <label>{{ $material->nombre }} ({{ $material->color }}) - ${{ number_format($material->precio_pieza, 2) }} por pieza</label>
        </div>
        @endforeach
    </div>
    <h3>Costo estimado: <span id="costo-estimado">(se calculará automáticamente)</span></h3>
    <button type="submit" class="btn btn-success">Crear ventana</button>
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
        document.getElementById('costo-estimado').innerText = '$' + total.toFixed(2);
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name^="materials"]').forEach(function(input) {
            input.addEventListener('input', calcularCosto);
        });
    });
</script>
@endsection
