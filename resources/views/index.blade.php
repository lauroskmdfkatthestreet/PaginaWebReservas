@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">Calendario de Reservas</h1>

    <!-- Botón para abrir el formulario de reserva -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalReserva">
        Crear Nueva Reserva
    </button>

    <!-- Calendario -->
    <div id="calendar"></div>
</div>

    <!-- Modal para el formulario de reserva -->
    <div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReservaLabel">Nueva Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reservas.store') }}" method="POST">
                        @csrf

                        <!-- SECCIÓN 1: Nueva Reserva -->
                        <div id="form-nueva-reserva">
                            <h5>Nueva Reserva</h5>

                           <div class="mb-3">
                            <label for="espacio" class="form-label">Espacio a Reservar</label>
                            <div class="d-flex align-items-center">
                                <select class="form-select w-50 me-2" id="espacio" name="espacio" required>
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
                        
                        
                        


                            <!-- SECCIÓN 2: Requerimientos -->
                        <div id="form-requerimientos" class="d-none">
                            <h5 class="text-center">Requerimientos</h5>

                            <!-- Número de personas esperadas -->
                            <div class="mb-3">
                                <label for="num_personas" class="form-label">Número de Personas Esperadas:</label>

                            <select class="form-control" name="num_personas" required>
                                @for ($i = 1; $i <= 500; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>


                            </div>

                            <!-- Audiovisuales -->
                            <h6 class="mt-3">Audiovisuales</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Computador" data-target="computador-select">
                                        <label class="form-check-label">Computador</label>

                                       <div id="computador-select" class="d-none ms-2 d-inline-block"> 
                                           <select class="form-control" name="cantidad Computador">                    <!--  este bloque refiere a el select de cantidad -->                     
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>    
                                    </div>



                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Camara" data-target="Camara-select">
                                        <label class="form-check-label">Camara</label>

                                         <div id="Camara-select" class="d-none ms-2 d-inline-block"> 
                                             <select class="form-control" name="cantidad Camara">                             <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>  

                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Conexión Internet" data-target="Conexion-Internet-select">
                                        <label class="form-check-label">Conexión a Internet</label>

                                        <div id="Conexion-Internet-select" class="d-none ms-2 d-inline-block"> 
                                              <select class="form-control" name="cantidad Conexion Internet">                               <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>  

                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Pantalla Proyección" data-target="Pantalla-Proyeccion-select">
                                        <label class="form-check-label">Pantalla para Proyección</label>

                                        <div id="Pantalla-Proyeccion-select" class="d-none ms-2 d-inline-block"> 
                                            <select class="form-control" name="cantidad Pantalla Proyeccion">                       <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>   

                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Pantalla TV" data-target="Pantalla-TV-select">
                                        <label class="form-check-label">Pantalla (TV)</label>

                                        <div id="Pantalla-TV-select" class="d-none ms-2 d-inline-block"> 
                                             <select class="form-control" name="cantidad Pantalla TV">                                <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>  

                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Video Bin" data-target="Video-Bin-select">
                                        <label class="form-check-label">Video Bin</label>

                                        <div id="Video-Bin-select" class="d-none ms-2 d-inline-block"> 
                                           <select class="form-control" name="cantidad Video Bin">                              <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>  

                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Sonido"  data-target="Sonido-select">
                                        <label class="form-check-label">Sonido</label>

                                        <div id="Sonido-select" class="d-none ms-2 d-inline-block"> 
                                              <select class="form-control" name="cantidad Sonido">                            <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>  

                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="audiovisuales[]" value="Micrófono" data-target="Microfono-select">
                                        <label class="form-check-label">Micrófono</label>

                                        <div id="Microfono-select" class="d-none ms-2 d-inline-block"> 
                                            <select class="form-control" name="cantidad Microfono">                              <!--  este bloque refiere a el select de cantidad -->                                                         
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
                                    <input type="text" class="form-control mt-2 d-none" id="audiovisuales_otro" name="audiovisuales_otro" placeholder="Especifique que recurso requiere">
                                </div>
                            </div>

                            <!-- Servicios Generales -->
                            <h6 class="mt-4">Servicios Generales</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="servicios_generales[]" value="Mesa" data-target="Mesa-select">
                                        <label class="form-check-label">Mesa</label>

                                        <div id="Mesa-select" class="d-none ms-2 d-inline-block"> 
                                           <select class="form-control" name="cantidad_mesa">                     <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>  

                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="servicios_generales[]" value="Mantel" data-target="Mantel-select">
                                        <label class="form-check-label">Mantel</label>

                                        <div id="Mantel-select" class="d-none ms-2 d-inline-block"> 
                                             <select class="form-control" name="cantidad_Mantel">                                <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>  

                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input otro-checkbox" type="checkbox" data-target="servicios_generales_otro">
                                        <label class="form-check-label">Otro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control mt-2 d-none" id="servicios_generales_otro" name="servicios_generales_otro" placeholder="Especifique que recurso requiere">
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
                                    <div class="form-check">
                                        <input class="form-check-input requerimiento-checkbox" type="checkbox" name="administracion[]" value="Refrigerio" data-target="Refrigerio-select">
                                        <label class="form-check-label">Refrigerio</label>

                                        <div id="Refrigerio-select" class="d-none ms-2 d-inline-block"> 
                                            <select class="form-control" name="cantidad_computador">                              <!--  este bloque refiere a el select de cantidad -->                                                         
                                                @for ($i = 1; $i <= 15; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>  
                                                @endfor
                                            </select>
                                       </div>   

                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input otro-checkbox" type="checkbox" data-target="administracion_otro">
                                        <label class="form-check-label">Otro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control mt-2 d-none" id="administracion_otro" name="administracion_otro" placeholder="Especifique que recurso requiere">
                                </div>
                            </div>

                            <!-- Botones de navegación -->
                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-secondary" id="btn-anterior">
                                    Anterior
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Reservar
                                </button>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


                    @push('scripts')
                    <script>
                 
                 
                 document.addEventListener('DOMContentLoaded', function () {
    console.log("El DOM está completamente cargado.");

    // Contenedor principal para delegar eventos
    const contenedorRequerimientos = document.querySelector('#form-requerimientos');
    console.log("Contenedor de requerimientos:", contenedorRequerimientos);

    // Evento delegado para checkboxes
    contenedorRequerimientos.addEventListener('change', function (event) {
        console.log("Evento change detectado en:", event.target);

        // Verificar si el elemento es un checkbox de requerimiento
        if (event.target.classList.contains('requerimiento-checkbox')) {
            const targetId = event.target.dataset.target; // ID del contenedor del select
            const selectContainer = document.getElementById(targetId);
            console.log("Select container:", selectContainer);

            // Mostrar u ocultar el select según el estado del checkbox
            if (event.target.checked) {
                selectContainer.classList.remove('d-none');
                console.log("Select mostrado:", targetId);
            } else {
                selectContainer.classList.add('d-none');
                console.log("Select ocultado:", targetId);
            }
        }
    });
});
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 $(document).ready(function () {
                        let espacioSelect = $('#espacio');
                        let otroEspacioInput = $('#otro_espacio');
                        let btnSiguiente = $('#btn-siguiente');
                        let btnAnterior = $('#btn-anterior');
                        let formNuevaReserva = $('#form-nueva-reserva');
                        let formRequerimientos = $('#form-requerimientos');

                        // Evento para mostrar/ocultar y habilitar/deshabilitar el campo "Otro espacio"
                        espacioSelect.on('change', function () {
                            if ($(this).val() === 'Otro') {
                                otroEspacioInput.removeClass('d-none')
                                                .prop('disabled', false)
                                                .attr('required', true);
                            } else {
                                otroEspacioInput.addClass('d-none')
                                                .prop('disabled', true)
                                                .removeAttr('required')
                                                .val('');
                            }
                        });

                        // Asegura que el campo se muestre si "Otro" ya está seleccionado al cargar la página
                        if (espacioSelect.val() === 'Otro') {
                            otroEspacioInput.removeClass('d-none')
                                            .prop('disabled', false)
                                            .attr('required', true);
                        }

                        // Lógica del botón "Siguiente"
                        btnSiguiente.on('click', function () {
                            formNuevaReserva.addClass('d-none'); // Ocultar la primera sección
                            formRequerimientos.removeClass('d-none'); // Mostrar la segunda sección
                        });

                        // Lógica del botón "Anterior"
                        btnAnterior.on('click', function () {
                            formRequerimientos.addClass('d-none'); // Ocultar la segunda sección
                            formNuevaReserva.removeClass('d-none'); // Mostrar la primera sección
                        });
                    });



            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.otro-checkbox').forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        let target = document.getElementById(this.dataset.target);
                        if (this.checked) {
                            target.classList.remove('d-none');
                            target.setAttribute('required', 'true');
                        } else {
                            target.classList.add('d-none');
                            target.removeAttribute('required');
                            target.value = ''; // Limpiar campo
                        }
                    });
                });
            });


            document.addEventListener('DOMContentLoaded', function () {
        // Contenedor principal para delegar eventos
        const contenedorRequerimientos = document.querySelector('#form-requerimientos');

        // Evento delegado para checkboxes
        contenedorRequerimientos.addEventListener('change', function (event) {
            if (event.target.classList.contains('requerimiento-checkbox')) {
                const targetId = event.target.dataset.target; // ID del contenedor del select
                const selectContainer = document.getElementById(targetId);

                if (event.target.checked) {
                    selectContainer.classList.remove('d-none'); // Mostrar select
                } else {
                    selectContainer.classList.add('d-none'); // Ocultar select
                }
            }
        });
    });

</script>




                    

@endpush



