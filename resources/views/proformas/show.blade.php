@extends('layouts.app')

@section('content')
<h1>Detalle de Proforma #{{ $proforma->id }}</h1>
<p>Fecha: {{ $proforma->fecha }}</p>
<p>Total: ${{ number_format($proforma->total, 2) }}</p>

<h2>Ventanas</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Medidas</th>
            <th>Colores</th>
            <th>Tipo Vidrio</th>
            <th>Cantidad</th>
            <th>Precio Total</th>
            <th>Materiales</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proforma->windows as $window)
        <tr>
            <td>{{ $window->id }}</td>
            <td>{{ $window->product->nombre ?? '-' }}</td>
            <td>{{ $window->alto }} x {{ $window->ancho }}</td>
            <td>{{ $window->color_aluminio }} / {{ $window->color_vidrio }}</td>
            <td>{{ $window->tipo_vidrio }}</td>
            <td>{{ $window->cantidad }}</td>
            <td>${{ number_format($window->precio_total, 2) }}</td>
            <td>
                <ul>
                @foreach($window->materials as $material)
                    <li>{{ $material->nombre }} ({{ $material->pivot->cantidad }})</li>
                @endforeach
                </ul>
            </td>
            <td>
                <form method="POST" action="{{ route('windows.destroy', $window->id) }}" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta ventana?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
