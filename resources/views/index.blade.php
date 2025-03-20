@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">Calendario de Reservas</h1>

        <div class="text-center my-4">
            <a href="{{ route('reservas.calendario') }}" class="btn btn-primary">
                Ver Calendario de Reservas
            </a>
        </div>

        <div id="calendar"></div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log("El DOM está completamente cargado en index.blade.php");

            // Aquí puedes agregar cualquier lógica adicional específica de index.blade.php
            // Por ejemplo, inicializar el calendario o cargar datos iniciales.
        });
    </script>
@endpush