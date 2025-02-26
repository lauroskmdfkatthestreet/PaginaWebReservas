@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">Calendario de Reservas</h1>
        <div id="calendar"></div>
    </div>

<!-- CSS de FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

<!-- Contenedor del calendario -->
<div id="calendar"></div>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/locales-all.min.js"> locale: 'es',
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        if (!calendarEl) {
            console.error("No se encontró el div con id='calendar'");
            return;
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            events: '/reservas/eventos' // Usamos la ruta corregida
        });

        calendar.render();
    });
</script>

@endsection
