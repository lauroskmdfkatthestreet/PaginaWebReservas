@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Calendario de Reservas</h1>
    <div id="calendar"></div>
</div>

<!-- Modal del Formulario (copiado desde index.blade.php con ajustes) -->
<div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReservaLabel">Nueva Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formReserva" action="{{ route('reservas.store') }}" method="POST">
                    @csrf

                    <!-- SECCIÓN 1: Nueva Reserva -->
                    <div id="form-nueva-reserva">
                        <h5>Nueva Reserva</h5>

                        <!-- Espacio a Reservar -->
               <!-- Espacio a Reservar -->
            <div class="mb-3">
                <label for="espacio_id" class="form-label">Espacio a Reservar</label>
                <div class="d-flex align-items-center">
                    <select class="form-select w-50 me-2" id="espacio_id" name="espacio_id" required>
                        <option value="" selected disabled>Selecciona un espacio</option>
                        <option value="Auditorio Tecnológico 1">Auditorio Tecnológico 1</option>
                        <option value="Auditorio Tecnológico 2">Auditorio Tecnológico 2</option>
                        <option value="Auditorio Tecnológico 3">Auditorio Tecnológico 3</option>
                        <option value="Auditorio audiovisual 4">Auditorio audiovisual 4</option>
                        <option value="Sala Informatica 1">Sala Informatica 1</option>
                        <option value="Sala Informatica 2">Sala Informatica 2</option>
                        <option value="Sala Informatica 3">Sala Informatica 3</option>
                        <option value="Sala de Juntas">Sala de Juntas</option>
                        <option value="Capilla - auditorio">Capilla - auditorio</option>
                        <option value="Biblioteca - infantil">Biblioteca - infantil</option>
                        <option value="Biblioteca - Bachillerato">Biblioteca - Bachillerato</option>
                        <option value="Biblioteca - Sala de Lectura">Biblioteca - Sala de Lectura</option>
                        <option value="Coliseo - Espacios Deportivos">Coliseo - Espacios Deportivos</option>
                        <option value="Laboratorio de física">Laboratorio de física</option>
                        <option value="Laboratorio de química">Laboratorio de química</option>
                        <option value="Emisora Colamer">Emisora Colamer</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <input type="text" class="form-control w-50 d-none" id="otro_espacio" 
                        name="otro_espacio" placeholder="Especifique el espacio" disabled>
                </div>
            </div>

                        <!-- Fecha y Horas -->
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Hora de Fin</label>
                            <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
                        </div>

                        <!-- Actividad y Programa -->
                        <div class="mb-3">
                            <label for="nombre_actividad" class="form-label">Nombre de la Actividad</label>
                            <input type="text" class="form-control" id="nombre_actividad" name="nombre_actividad" required>
                        </div>
                        <div class="mb-3">
                            <label for="programa_evento" class="form-label">Programa del Evento</label>
                            <textarea class="form-control" id="programa_evento" name="programa_evento" rows="4"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" id="btn-siguiente">Siguiente</button>
                        </div>
                    </div>

                 <!-- SECCIÓN 2: Requerimientos -->
<div id="form-requerimientos" class="d-none">
    <h5 class="mt-4">Requerimientos</h5>

    <!-- Número de Personas -->
    <div class="mb-3">
        <label for="num_personas" class="form-label">Número de Personas</label>
        <select class="form-control" name="num_personas" required>
            @for ($i = 1; $i <= 500; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>

    <!-- 🔹 Audiovisuales -->
    <h6 class="mt-3">Audiovisuales</h6>
    <div class="row">
        @php
            $audiovisuales = ['Computador', 'Cámara', 'Conexión a Internet', 'Pantalla para Proyección', 
                              'Pantalla (TV)', 'Video Bin', 'Sonido', 'Micrófono', 'Otro'];
        @endphp
        @foreach ($audiovisuales as $item)
            <div class="form-check">
                <input class="form-check-input requerimiento-checkbox" type="checkbox" 
                    name="audiovisuales[]" value="{{ $item }}" 
                    data-target="{{ \Str::slug($item) }}-select">
                <label class="form-check-label">{{ $item }}</label>
                @if (!in_array($item, ['Conexión a Internet', 'Sonido'])) 
                    <div id="{{ \Str::slug($item) }}-select" class="d-none ms-2 d-inline-block">
                        <select class="form-control" name="cantidad[{{ $item }}]">
                            @for ($i = 1; $i <= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- 🔹 Servicios Generales -->
    <h6 class="mt-3">Servicios Generales</h6>
    <div class="row">
        @php
            $servicios = ['Mesa', 'Mantel', 'Extensión Eléctrica', 'Multitoma Eléctrica', 'Otro'];
        @endphp
        @foreach ($servicios as $item)
            <div class="form-check">
                <input class="form-check-input requerimiento-checkbox" type="checkbox" 
                    name="servicios_generales[]" value="{{ $item }}" 
                    data-target="{{ \Str::slug($item) }}-select">
                <label class="form-check-label">{{ $item }}</label>
                <div id="{{ \Str::slug($item) }}-select" class="d-none ms-2 d-inline-block">
                    <select class="form-control" name="cantidad[{{ $item }}]">
                        @for ($i = 1; $i <= 15; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 🔹 Comunicaciones -->
    <h6 class="mt-3">Comunicaciones</h6>
    <div class="row">
        @php
            $comunicaciones = ['Fotografía', 'Video', 'Otro'];
        @endphp
        @foreach ($comunicaciones as $item)
            <div class="form-check">
                <input class="form-check-input requerimiento-checkbox" type="checkbox" 
                    name="comunicaciones[]" value="{{ $item }}" 
                    data-target="{{ \Str::slug($item) }}-select">
                <label class="form-check-label">{{ $item }}</label>
                <div id="{{ \Str::slug($item) }}-select" class="d-none ms-2 d-inline-block">
                    <select class="form-control" name="cantidad[{{ $item }}]">
                        @for ($i = 1; $i <= 15; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 🔹 Administración -->
    <h6 class="mt-3">Administración</h6>
    <div class="row">
        @php
            $administracion = ['Refrigerio', 'Agua', 'Vasos', 'Otro'];
        @endphp
        @foreach ($administracion as $item)
            <div class="form-check">
                <input class="form-check-input requerimiento-checkbox" type="checkbox" 
                    name="administracion[]" value="{{ $item }}" 
                    data-target="{{ \Str::slug($item) }}-select">
                <label class="form-check-label">{{ $item }}</label>
                <div id="{{ \Str::slug($item) }}-select" class="d-none ms-2 d-inline-block">
                    <select class="form-control" name="cantidad[{{ $item }}]">
                        @for ($i = 1; $i <= 15; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Botones de Navegación -->
    <div class="text-end mt-4">
        <button type="button" class="btn btn-secondary" id="btn-anterior">Anterior</button>
        <button type="submit" class="btn btn-success">Reservar</button>
    </div>
</div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Dependencias -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<!-- Scripts Personalizados -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración FullCalendar
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'es',
        dateClick: function(info) {
            document.getElementById('fecha').value = info.dateStr;
            new bootstrap.Modal(document.getElementById('modalReserva')).show();
        },
        events: '/getEvents'
    });
    calendar.render();

    // Lógica jQuery del Formulario
    $(document).ready(function() {
        // Mostrar campo "Otro espacio"
        $('#espacio_id').on('change', function() {
            if ($(this).val() === 'Otro') {
                $('#otro_espacio').removeClass('d-none').prop('disabled', false).attr('required', true);
            } else {
                $('#otro_espacio').addClass('d-none').prop('disabled', true).removeAttr('required').val('');
            }
        });

        // Navegación entre secciones
        $('#btn-siguiente').click(() => {
            $('#form-nueva-reserva').addClass('d-none');
            $('#form-requerimientos').removeClass('d-none');
        });

        $('#btn-anterior').click(() => {
            $('#form-requerimientos').addClass('d-none');
            $('#form-nueva-reserva').removeClass('d-none');
        });

        // Mostrar selects al marcar checkboxes
        $(document).on('change', '.requerimiento-checkbox', function() {
            const target = $(this).data('target');
            $(`#${target}`).toggleClass('d-none', !this.checked);
        });
    });

    // Envío del Formulario con AJAX
    document.getElementById('formReserva').addEventListener('submit', function(e) {
        e.preventDefault();
        fetch(this.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: new FormData(this)
        }).then(response => {
            if (response.ok) {
                calendar.refetchEvents();
                this.reset();
                bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
                $('#form-nueva-reserva').removeClass('d-none');
                $('#form-requerimientos').addClass('d-none');
            }
        });
    });
});
</script>
@endsection