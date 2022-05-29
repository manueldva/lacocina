<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Alert;
use App\User;
use App\Models\Calle;
use Auth;
use Carbon\Carbon;

class CalleController extends Controller
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

        $segment = 'calles_c';

        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar

        $calles =  Calle::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);

        

        return view('calles.index', compact('calles', 'segment','buscador','dato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $segment = 'calles_c';

        return view('calles.create', compact('segment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $messages = [
            'descripcion.required' => 'El campo descripcion es obligatorio.',
 
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:256|unique:calles,descripcion'
        ], $messages);

        $calle = Calle::create($request->all());

        Alert::success('Registro Creado', 'Exitosamente');
        return redirect()->route('calles.edit', $calle->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Calle $calle)
    {
       // $tipocontacto = Tipocontacto::find($id);
        $segment = 'calles_c';
        $show = 1;
        //Alert::toast('Toast Message', 'success');
        return view('calles.edit', compact('segment','calle', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Calle $calle)
    {
        
        //$tipocontacto = Tipocontacto::find($id);
        //dd($plan);
        $show = 0;
        $segment = 'calles_c';

        return view('calles.edit', compact('segment', 'calle','show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calle $calle)
    {
        //$tipocontacto = Tipocontacto::find($id);

        $messages = [
            'descripcion.required' => 'El campo descripcion es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:256|unique:calles,descripcion,' . $calle->id
        ], $messages);


  
        $calle->update($request->all());
  
        Alert::success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('calles.edit', $calle->id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calle $calle)
    {
        
        /*if(Cliente::where('plan_id', '=', $id)->first()) {
            alert()->error('Este registro no se puede eliminar', 'Error');
            return back();
        } else {*/
            $calle->delete();
            //Alert::success('Eliminado correctamente')->persistent();
            //alert()->success('Registro Eliminado', 'Exitosamente')->toToast();
            Alert::success('Registro Eliminado', 'Exitosamente');
            return back();
        //}
        
    }
}
