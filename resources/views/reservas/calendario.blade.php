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

<!-- Modal para el formulario completo de nueva reserva -->
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
                                    <option value="Sala - Juntas">Sala de Juntas</option>
                                    <option value="Capilla - auditorio">Capilla - auditorio</option>
                                    <option value="Biblioteca - Infantil">Biblioteca - infantil</option>
                                    <option value="Biblioteca - Bachillerato">Biblioteca - Bachillerato</option>
                                    <option value="Biblioteca - Sala de Lectura">Biblioteca - Sala de Lectura</option>
                                    <option value="Coliseo - Espacios Deportivos">Coliseo - Espacios Deportivos</option>
                                    <option value="Laboratorio de física">Laboratorio de física</option>
                                    <option value="Laboratorio de quimica">Laboratorio de quimica</option>
                                    <option value="Emisora Colamer">Emisora Colamer</option>
                                    <option value="Otro">Otro</option>
                                </select>


                <!-- Campo de texto para "Otro", oculto por defecto con Bootstrap -->
                                <input type="text" class="form-control w-50 d-none" id="otro_espacio" name="otro_espacio" 
                                       placeholder="Especifique el espacio" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>

                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                        </div>

                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Hora de Fin</label>
                            <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombre_actividad" class="form-label">Nombre de la Actividad</label>
                            <input type="text" class="form-control" id="nombre_actividad" name="nombre_actividad" required>
                        </div>

                        <div class="mb-3">
                            <label for="programa_evento" class="form-label">Programa del Evento</label>
                            <textarea class="form-control" id="programa_evento" name="programa_evento" rows="4" placeholder="Escriba la organización o paso a paso del evento"></textarea>
                        </div>

                        <div class="text-end">
                                <button type="button" class="btn btn-secondary" id="btn-siguiente">
                                    Siguiente
                                </button>
                        </div>
                    </div>





         <!-- SECCIÓN 2: Requerimientos (AJUSTES REALIZADOS) -->
         <div id="form-requerimientos" class="d-none">
            <h5 class="mt-4">Requerimientos</h5>

            <!-- Número de personas (sin cambios) -->
            <div class="mb-3">
                <label for="num_personas" class="form-label">Número de Personas Esperadas:</label>
                <select class="form-control" name="num_personas" required>
                    @for ($i = 1; $i <= 500; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <!-- Audiovisuales (todos los selects ajustados) -->
            <h6 class="mt-3">Audiovisuales</h6>
            <div class="row">
                <!-- Computador -->
                <div class="form-check">
                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Computador" data-target="computador-select">
                    <label class="form-check-label">Computador</label>
                    <div id="computador-select" class="d-none ms-2 d-inline-block">
                        <select class="form-control cantidad-select" name="cantidad[Computador]">
                            <option value="">Seleccione cantidad</option> <!-- Añadido -->
                            @for ($i = 1; $i <= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Camara -->
                <div class="form-check">
                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Camara" data-target="Camara-select">
                    <label class="form-check-label">Camara</label>
                    <div id="Camara-select" class="d-none ms-2 d-inline-block">
                        <select class="form-control cantidad-select" name="cantidad[Camara]"> <!-- Corregido -->
                            <option value="">Seleccione cantidad</option>
                            @for ($i = 1; $i <= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Conexión Internet -->
                <div class="form-check">
                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Conexión Internet" data-target="Conexion-Internet-select">
                    <label class="form-check-label">Conexión a Internet</label>
                    <div id="Conexion-Internet-select" class="d-none ms-2 d-inline-block">
                        <select class="form-control cantidad-select" name="cantidad[Conexión Internet]"> <!-- Corregido -->
                            <option value="">Seleccione cantidad</option>
                            @for ($i = 1; $i <= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Pantalla Proyección -->
                <div class="form-check">
                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Pantalla Proyección" data-target="Pantalla-Proyeccion-select">
                    <label class="form-check-label">Pantalla para Proyección</label>
                    <div id="Pantalla-Proyeccion-select" class="d-none ms-2 d-inline-block">
                        <select class="form-control cantidad-select" name="cantidad[Pantalla Proyección]"> <!-- Corregido -->
                            <option value="">Seleccione cantidad</option>
                            @for ($i = 1; $i <= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Pantalla TV -->
                <div class="form-check">
                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Pantalla TV" data-target="Pantalla-TV-select">
                    <label class="form-check-label">Pantalla (TV)</label>
                    <div id="Pantalla-TV-select" class="d-none ms-2 d-inline-block">
                        <select class="form-control cantidad-select" name="cantidad[Pantalla TV]"> <!-- Corregido -->
                            <option value="">Seleccione cantidad</option>
                            @for ($i = 1; $i <= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Video Bin -->
                <div class="form-check">
                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Video Bin" data-target="Video-Bin-select">
                    <label class="form-check-label">Video Bin</label>
                    <div id="Video-Bin-select" class="d-none ms-2 d-inline-block">
                        <select class="form-control cantidad-select" name="cantidad[Video Bin]"> <!-- Corregido -->
                            <option value="">Seleccione cantidad</option>
                            @for ($i = 1; $i <= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Sonido -->
                <div class="form-check">
                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Sonido" data-target="Sonido-select">
                    <label class="form-check-label">Sonido</label>
                    <div id="Sonido-select" class="d-none ms-2 d-inline-block">
                        <select class="form-control cantidad-select" name="cantidad[Sonido]"> <!-- Corregido -->
                            <option value="">Seleccione cantidad</option>
                            @for ($i = 1; $i <= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Micrófono -->
                <div class="form-check">
                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Micrófono" data-target="Microfono-select">
                    <label class="form-check-label">Micrófono</label>
                    <div id="Microfono-select" class="d-none ms-2 d-inline-block">
                        <select class="form-control cantidad-select" name="cantidad[Micrófono]"> <!-- Corregido -->
                            <option value="">Seleccione cantidad</option>
                            @for ($i = 1; $i <= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-check">
                                        <input class="form-check-input otro-checkbox" type="checkbox" data-target="audiovisuales_otro">
                                        <label class="form-check-label">Otro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control mt-2 d-none" id="audiovisuales_otro" name="audiovisuales_otro" placeholder="Especifique qué recurso requiere">
                                </div>
                            </div>

                                    <!-- Servicios Generales -->
                                    <h6 class="mt-4">Servicios Generales</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="servicios_generales[]" value="Mesa" data-target="Mesa-select">
                                    <label class="form-check-label ms-2">Mesa</label>
                                    <select class="form-control ms-2 w-auto d-none" id="Mesa-select" name="cantidad_mesa">
                                        @for ($i = 1; $i <= 15; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>  
                                        @endfor
                                    </select>
                                </div>

                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="servicios_generales[]" value="Mantel" data-target="Mantel-select">
                                    <label class="form-check-label ms-2">Mantel</label>
                                    <select class="form-control ms-2 w-auto d-none" id="Mantel-select" name="cantidad_Mantel">
                                        @for ($i = 1; $i <= 15; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>  
                                        @endfor
                                    </select>
                                </div>

                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="servicios_generales[]" value="Extension_electrica" data-target="extension-select">
                                    <label class="form-check-label ms-2">Extensión eléctrica</label>
                                    <select class="form-control ms-2 w-auto d-none" id="extension-select" name="cantidad_Extension">
                                        @for ($i = 1; $i <= 15; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>  
                                        @endfor
                                    </select>
                                </div>

                                
                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input requerimiento-checkbox" type="checkbox" name="servicios_generales[]" value="Multitoma" data-target="Multitoma-select">
                                    <label class="form-check-label ms-2">Multitoma</label>
                                    <select class="form-control ms-2 w-auto d-none" id="Multitoma-select" name="cantidad_Multitoma">
                                        @for ($i = 1; $i <= 15; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>  
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input otro-checkbox" type="checkbox" data-target="servicios_generales_otro">
                                    <label class="form-check-label">Otro</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <input type="text" class="form-control mt-2 d-none" id="servicios_generales_otro" name="servicios_generales_otro" placeholder="Especifique qué recurso requiere">
                            </div>
                        </div>
                        
                                 <!-- Comunicaciones -->
                                 <h6 class="mt-4">Comunicaciones</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="comunicaciones[]" value="Fotografía" data-target="Fotografia-select">
                                        <label class="form-check-label">Fotografía</label>

                                        <div id="Fotografia-select" class="d-none ms-2 d-inline-block"> 
                                            <select class="form-control" name="cantidad_Fotografia">                                  <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>  
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="comunicaciones[]" value="Video" data-target="Video-select">
                                        <label class="form-check-label">Video</label>

                                        <div id="Video-select" class="d-none ms-2 d-inline-block"> 
                                            <select class="form-control" name="cantidad_video">                               <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>  
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input otro-checkbox" type="checkbox" data-target="comunicaciones_otro">
                                        <label class="form-check-label">Otro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control mt-2 d-none" id="comunicaciones_otro" name="comunicaciones_otro" placeholder="Especifique que recurso requiere">
                                </div>
                            </div>

                                                                       <!-- Administración -->
                                                                       <h6 class="mt-4">Administración</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="administracion[]" value="Refrigerio" data-target="Refrigerio-select">
                                        <label class="form-check-label ms-2">Refrigerio</label>
                                        <select class="form-control ms-2 w-auto d-none" id="Refrigerio-select" name="cantidad_Refrigerio">
                                            @for ($i = 1; $i <= 15; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>  
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="administracion[]" value="Agua" data-target="Agua-select">
                                        <label class="form-check-label ms-2">Agua</label>
                                        <select class="form-control ms-2 w-auto d-none" id="Agua-select" name="cantidad_Agua">
                                            @for ($i = 1; $i <= 15; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>  
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="administracion[]" value="Vasos" data-target="Vasos-select">
                                        <label class="form-check-label ms-2">Vasos</label>
                                        <select class="form-control ms-2 w-auto d-none" id="Vasos-select" name="cantidad_Vasos">
                                            @for ($i = 1; $i <= 15; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>  
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input otro-checkbox" type="checkbox" data-target="administracion_otro">
                                        <label class="form-check-label">Otro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control mt-2 d-none" id="administracion_otro" name="administracion_otro" placeholder="Especifique qué recurso requiere">
                                </div>
                            </div>


            </div> 

            <!-- Botones de navegación -->
            <div class="text-end mt-4">
                <button type="button" class="btn btn-secondary" id="btn-anterior">Anterior</button>
                <button type="submit" class="btn btn-success">Reservar</button>
            </div>
        </div>
    </form>
</div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        selectable: true,
        events: '/getEvents',

        // Al hacer clic en una fecha del calendario
        dateClick: function (info) {
            document.getElementById('fecha').value = info.dateStr;
            var modal = new bootstrap.Modal(document.getElementById('modalReserva'));
            modal.show();
        }
    });

    calendar.render();

    // Manejador de envío del formulario
    document.getElementById('formReserva').addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(this);
        fetch('/getEvents', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        }).then(response => {
            if (response.ok) {
                alert('Reserva creada correctamente.');
                calendar.refetchEvents();
                var modal = bootstrap.Modal.getInstance(document.getElementById('modalReserva'));
                modal.hide();
                this.reset();
                document.getElementById('form-nueva-reserva').classList.remove('d-none');
                document.getElementById('form-requerimientos').classList.add('d-none');
            } else {
                alert('Error al crear la reserva.');
            }
        }).catch(error => console.error('Error:', error));
    });

    // Lógica de navegación entre formularios
    document.getElementById('btn-siguiente').addEventListener('click', function () {
        document.getElementById('form-nueva-reserva').classList.add('d-none');
        document.getElementById('form-requerimientos').classList.remove('d-none');
    });

    document.getElementById('btn-anterior').addEventListener('click', function () {
        document.getElementById('form-requerimientos').classList.add('d-none');
        document.getElementById('form-nueva-reserva').classList.remove('d-none');
    });

    // Lógica para mostrar/ocultar selects de cantidad y campos "Otro"
    document.querySelector('#form-requerimientos').addEventListener('change', function (event) {
        if (event.target.classList.contains('requerimiento-checkbox')) {
            const targetId = event.target.dataset.target; // ID del select dependiente
            const selectContainer = document.getElementById(targetId);
            if (event.target.checked) {
                selectContainer.classList.remove('d-none'); // Mostrar el select
                selectContainer.required = true;
            } else {
                selectContainer.classList.add('d-none'); // Ocultar el select
                selectContainer.required = false;
                selectContainer.value = ''; // Limpiar la selección
            }
        }

        // Lógica para los checkboxes "Otro"
        if (event.target.classList.contains('otro-checkbox')) {
            const targetTextId = event.target.dataset.target;
            const textInput = document.getElementById(targetTextId);
            if (event.target.checked) {
                textInput.classList.remove('d-none');
                textInput.required = true;
            } else {
                textInput.classList.add('d-none');
                textInput.required = false;
                textInput.value = ''; // Limpiar el campo
            }
        }
    });

});

</script>



@endsection
