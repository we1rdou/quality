@extends('layouts.app')

@section('content')
<h1 class="mb-4">Productos de Aluminio y Vidrio</h1>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <h3 class="card-title">Ventana</h3>
                <p class="card-text">Personaliza tu ventana de aluminio y vidrio según tus necesidades.</p>
                <a href="{{ route('windows.create', ['base' => 1]) }}" class="btn btn-primary">Personalizar Ventana</a>
            </div>
        </div>
    </div>
</div>
@endsection
