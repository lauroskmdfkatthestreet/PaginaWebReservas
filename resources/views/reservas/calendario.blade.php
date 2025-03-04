@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">Calendario de Reservas</h1>
        <div id="calendar"></div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            selectable: true, // Permitir selección de fechas

            // Obtener eventos desde Laravel
            events: function(fetchInfo, successCallback, failureCallback) {
                fetch("{{ route('reservas.index') }}")
                .then(response => response.json()) // Convertir la respuesta a JSON
                .then(data => successCallback(data)) // Pasar los datos a FullCalendar
                .catch(error => failureCallback(error)); // Manejo de errores
            },

            // Evento al seleccionar una fecha
            select: function(info) {
                var nombreActividad = prompt("Ingrese el nombre de la actividad:");
                if (!nombreActividad) return; // Si no ingresa nombre, cancelar

                var horaInicio = prompt("Ingrese la hora de inicio (HH:MM:SS):");
                if (!horaInicio) return; // Si no ingresa hora, cancelar

                var horaFin = prompt("Ingrese la hora de finalización (HH:MM:SS):");
                if (!horaFin) return; // Si no ingresa hora, cancelar

                fetch("{{ route('reservas.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        nombre_actividad: nombreActividad,
                        fecha: info.startStr,
                        hora_inicio: horaInicio,
                        hora_fin: horaFin,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Reserva creada con éxito.");
                        calendar.refetchEvents(); // Recargar eventos en el calendario
                    } else {
                        alert("Error al crear la reserva.");
                    }
                })
                .catch(error => console.log(error));
            }
        });

        calendar.render();
    });

    
    
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            selectable: true, // Permite seleccionar días
            dateClick: function(info) {
                // Configura la fecha seleccionada en el formulario
                document.getElementById('fecha').value = info.dateStr;
                // Abre el modal de Bootstrap
                var myModal = new bootstrap.Modal(document.getElementById('reservaModal'));
                myModal.show();
            }
        });
        calendar.render();



</script>


@endsection
