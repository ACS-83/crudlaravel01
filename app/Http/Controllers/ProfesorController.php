<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profesores=Profesor::orderBy('nombre')->orderBy('apellidos')->paginate(5);
        return view('profesores.index', compact('profesores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profesores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //Validar
         $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:50'],
            'apellidos' => ['required', 'string', 'min:3', 'max:90'],
            'email' => ['required', 'string', 'min:5', 'max:60', 'unique:profesors,email'],
            'localidad' => ['required', 'string', 'min:3', 'max:90']
        ]);
        //Procesar
        try {
            Profesor::create($request->all());
        } catch (\Exception $ex) {
            return redirect()->route('profesores.index')->with("mensaje", "Error ".$ex->getMessage());
        }
        return redirect()->route('profesores.index')->with("mensaje", "Profesor creado");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function show(Profesor $profesore)
    {
        return view('profesores.detalles', compact('profesore'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function edit(Profesor $profesore)
    {
        return view('profesores.editar', compact('profesore'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profesor $profesore)
    {
         //Validar
         $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:50'],
            'apellidos' => ['required', 'string', 'min:3', 'max:90'],
            'email' => ['required', 'string', 'min:5', 'max:60', 'unique:profesors,email'.$profesore->id],
            'localidad' => ['required', 'string', 'min:3', 'max:90'],
        ]);
        //Procesar
        try {
            $profesore->update($request->all());
        } catch (\Exception $ex) {
            return redirect()->route('profesores.index')->with("mensaje", "Error ".$ex->getMessage());
        }
        return redirect()->route('profesores.index')->with("mensaje", "Profesor actualizado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profesor $profesore)
    {
        try {
            $profesore->delete();
        } catch (\Exception $ex) {
            return redirect()->route('profesores.index')->with("mensaje", "Error:".$ex->getMessage());
        }
        return redirect()->route('profesores.index')->with("mensaje", "Profesor eliminado");
    }
}
