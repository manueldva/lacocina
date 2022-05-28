<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Alert;
use App\User;
use App\Models\Tipoantecedentemedico;
use Auth;
use Carbon\Carbon;

class TipoantecedentemedicoController extends Controller
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

        $segment = 'tipoantecedentemedicos_c';

        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar

        $tipoantecedentemedicos =  Tipoantecedentemedico::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);

        

        return view('tipoantecedentemedicos.index', compact('tipoantecedentemedicos', 'segment','buscador','dato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $segment = 'tipoantecedentemedico_c';

        return view('tipoantecedentemedicos.create', compact('segment'));
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
            'descripcion' => 'required|max:256|unique:tipoantecedentesmedicos,descripcion'
        ], $messages);

        $tipoantecedentemedico = Tipoantecedentemedico::create($request->all());

        Alert::success('Registro Creado', 'Exitosamente');
        return redirect()->route('tipoantecedentemedicos.edit', $tipoantecedentemedico->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tipoantecedentemedico $tipoantecedentemedico)
    {
       // $tipocontacto = Tipocontacto::find($id);
        $segment = 'tipoantecedentemedico_c';
        $show = 1;
        //Alert::toast('Toast Message', 'success');
        return view('tipoantecedentemedicos.edit', compact('segment','tipoantecedentemedico', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipoantecedentemedico $tipoantecedentemedico)
    {
        
        //$tipocontacto = Tipocontacto::find($id);
        //dd($plan);
        $show = 0;
        $segment = 'tipoantecedentemedico_c';

        return view('tipoantecedentemedicos.edit', compact('segment', 'tipoantecedentemedico','show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipoantecedentemedico $tipoantecedentemedico)
    {
        //$tipocontacto = Tipocontacto::find($id);

        $messages = [
            'descripcion.required' => 'El campo descripcion es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:256|unique:tipoantecedentesmedicos,descripcion,' . $tipoantecedentemedico->id
        ], $messages);


  
        $tipoantecedentemedico->update($request->all());
  
        Alert::success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('tipoantecedentemedicos.edit', $tipoantecedentemedico->id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipoantecedentemedico $tipoantecedentemedico)
    {
        
        /*if(Cliente::where('plan_id', '=', $id)->first()) {
            alert()->error('Este registro no se puede eliminar', 'Error');
            return back();
        } else {*/
            $tipoantecedentemedico->delete();
            //Alert::success('Eliminado correctamente')->persistent();
            //alert()->success('Registro Eliminado', 'Exitosamente')->toToast();
            Alert::success('Registro Eliminado', 'Exitosamente');
            return back();
        //}
        
    }
}
