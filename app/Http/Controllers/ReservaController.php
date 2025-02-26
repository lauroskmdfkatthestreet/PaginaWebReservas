<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Espacio;

class ReservaController extends Controller
{
    /**
     * Restringe el acceso a usuarios autenticados.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el formulario de creación de reservas.
     */
    public function create()
    {
        $espacios = Espacio::all(); // Cargar todos los espacios disponibles
        return view('reservas.create', compact('espacios'));
    }

    /**
     * Muestra la lista de reservas del usuario autenticado en el calendario.
     */
    public function index()
    {
        return view('reservas.index');
    }

    /**
     * Devuelve las reservas en formato JSON para FullCalendar.
     */
    public function getReservations()
    {
        $reservas = Reserva::where('user_id', Auth::id())->get();

        $events = [];

        foreach ($reservas as $reserva) {
            $events[] = [
                'id' => $reserva->id,
                'title' => $reserva->nombre_actividad,
                'start' => "{$reserva->fecha}T{$reserva->hora_inicio}",
                'end' => "{$reserva->fecha}T{$reserva->hora_fin}",
            ];
        }

        return response()->json($events);
    }

    /**
     * Muestra la vista del calendario.
     */
    public function calendario()
    {
        return view('reservas.calendario');
    }

    /**
     * Devuelve todos los eventos en formato JSON.
     */
    public function obtenerEventos()
    {
        $reservas = Reserva::all();
        $eventos = [];

        foreach ($reservas as $reserva) {
            $eventos[] = [
                'title' => $reserva->nombre_actividad,
                'start' => "{$reserva->fecha}T{$reserva->hora_inicio}",
                'end' => "{$reserva->fecha}T{$reserva->hora_fin}",
            ];
        }

        return response()->json($eventos);
    }

    /**
     * Guarda una nueva reserva en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'espacio' => 'required_without:otro_espacio|string',
            'otro_espacio' => 'nullable|required_if:espacio,Otro|string',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'nombre_actividad' => 'required|string|max:255',
            'num_personas' => 'nullable|integer|min:1',
            'programa_evento' => 'nullable|string',
        ]);

        Reserva::create([
            'usuario_id' => Auth::id(),
            'espacio' => $request->espacio !== 'Otro' ? $request->espacio : null,
            'otro_espacio' => $request->espacio === 'Otro' ? $request->otro_espacio : null,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'nombre_actividad' => $request->nombre_actividad,
            'num_personas' => $request->num_personas,
            'programa_evento' => $request->programa_evento,
        ]);

        return redirect()->route('reservas.calendario')->with('success', 'Reserva creada con éxito');
    }

    /**
     * Muestra el formulario de edición de una reserva.
     */
    public function edit(Reserva $reserva)
    {
        if ($reserva->user_id !== Auth::id()) {
            abort(403, 'No tienes permisos para editar esta reserva.');
        }

        $espacios = $this->getEspacios();
        return view('reservas.edit', compact('reserva', 'espacios'));
    }

    /**
     * Actualiza una reserva en la base de datos.
     */
    public function update(Request $request, Reserva $reserva)
    {
        if ($reserva->user_id !== Auth::id()) {
            abort(403, 'No tienes permisos para actualizar esta reserva.');
        }

        $request->validate([
            'espacio' => 'required|string',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'nombre_actividad' => 'required|string|max:255',
        ]);

        $reserva->update($request->all());

        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    /**
     * Elimina una reserva.
     */
    public function destroy(Reserva $reserva)
    {
        if ($reserva->user_id !== Auth::id()) {
            abort(403, 'No tienes permisos para eliminar esta reserva.');
        }

        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }

    /**
     * Devuelve una lista de los espacios disponibles.
     */
    private function getEspacios()
    {
        return [
            'Auditorio Tecnológico 1',
            'Auditorio Tecnológico 2',
            'Auditorio Tecnológico 3',
            'Auditorio Audiovisual 4',
            'Sala Informatica 1',
            'Sala Informatica 2',
            'Sala Informatica 3',
            'Sala - Juntas',
            'Capilla - auditorio',
            'Biblioteca - Infantil',
            'Biblioteca - Bachillerato',
            'Biblioteca - Sala de lectura',
            'Coliseo - Espacios deportivos',
            'Laboratorio de física',
            'Laboratorio de química',
            'Emisora Colamer',
            'Otro'
        ];
    }

    /**
     * Devuelve los eventos en formato JSON.
     */
    public function getEvents()
    {
        $reservas = Reserva::all();
        $events = [];

        foreach ($reservas as $reserva) {
            $events[] = [
                'id' => $reserva->id,
                'title' => $reserva->nombre_actividad,
                'start' => "{$reserva->fecha}T{$reserva->hora_inicio}",
                'end' => "{$reserva->fecha}T{$reserva->hora_fin}",
            ];
        }

        return response()->json($events);
    }
}
