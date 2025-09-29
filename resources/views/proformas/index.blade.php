@extends('layouts.app')

@section('content')
<h1>Mis Proformas</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proformas as $proforma)
        <tr>
            <td>{{ $proforma->id }}</td>
            <td>{{ $proforma->fecha }}</td>
            <td>${{ number_format($proforma->total, 2) }}</td>
            <td>
                <a href="{{ route('proformas.show', $proforma->id) }}" class="btn btn-primary">Ver detalles</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
