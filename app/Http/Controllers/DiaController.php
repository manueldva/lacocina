<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Alert;
use App\User;
use App\Models\Dia;
use Auth;
use Carbon\Carbon;

class DiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $segment = 'dias_c';

        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar

        $dias =  Dia::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);

        

        return view('dias.index', compact('dias', 'segment','buscador','dato'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dia $dia)
    {
       // $tipocontacto = Tipocontacto::find($id);
        $segment = 'dias_c';
        $show = 1;
        //Alert::toast('Toast Message', 'success');
        return view('dias.edit', compact('segment','dia', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dia $dia)
    {
        
        //$tipocontacto = Tipocontacto::find($id);
        //dd($plan);
        $show = 0;
        $segment = 'dias_c';

        return view('dias.edit', compact('segment', 'dia','show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dia $dia)
    {
        //$tipocontacto = Tipocontacto::find($id);

        $messages = [
            'descripcion.required' => 'El campo descripcion es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:256|unique:dias,descripcion,' . $dia->id
        ], $messages);


  
        $dia->update($request->all());
  
        Alert::success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('dias.edit', $dia->id);   
    }

   
}
