<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Alert;
use App\User;
use App\Models\Tipoantecedentemedico;
use App\Models\Antecedentemedico;
use Auth;
use Carbon\Carbon;

class AntecedentemedicoController extends Controller
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

        $segment = 'antecedentemedicos_c';

        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar

        $antecedentemedicos =  Antecedentemedico::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);  

        return view('antecedentemedicos.index', compact('antecedentemedicos', 'segment','buscador','dato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $segment = 'antecedentemedicos_c';

        $tipoantecedentemedicos = Tipoantecedentemedico::all();
        return view('antecedentemedicos.create', compact('segment','tipoantecedentemedicos'));
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
            'tipoantecedentemedico_id.required' => 'El campo tipo de antecedente es obligatorio.'
 
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:256|unique:tipoantecedentesmedicos,descripcion',
            'tipoantecedentemedico_id' => 'required'
        ], $messages);

        $antecedentemedico = Antecedentemedico::create($request->all());

        Alert::success('Registro Creado', 'Exitosamente');
        return redirect()->route('antecedentemedicos.edit', $antecedentemedico->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Antecedentemedico $antecedentemedico)
    {
       // $tipocontacto = Tipocontacto::find($id);
        $segment = 'antecedentemedicos_c';
        $show = 1;

        $tipoantecedentemedicos = Tipoantecedentemedico::all();
        //Alert::toast('Toast Message', 'success');
        return view('antecedentemedicos.edit', compact('segment','antecedentemedico','tipoantecedentemedicos', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Antecedentemedico $antecedentemedico)
    {
        
        //$tipocontacto = Tipocontacto::find($id);
        //dd($plan);
        $show = 0;
        $segment = 'antecedentemedicos_c';

        $tipoantecedentemedicos = Tipoantecedentemedico::all();

        return view('antecedentemedicos.edit', compact('segment', 'antecedentemedico', 'tipoantecedentemedicos','show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Antecedentemedico $antecedentemedico)
    {
        //$tipocontacto = Tipocontacto::find($id);

        $messages = [
            'descripcion.required' => 'El campo descripcion es obligatorio.',
            'tipoantecedentemedico_id.required' => 'El campo tipo de antecedente es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:256|unique:antecedentesmedicos,descripcion,' . $antecedentemedico->id,
            'tipoantecedentemedico_id' => 'required'
        ], $messages);


  
        $antecedentemedico->update($request->all());
  
        Alert::success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('antecedentemedicos.edit', $antecedentemedico->id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Antecedentemedico $antecedentemedico)
    {
        
        /*if(Cliente::where('plan_id', '=', $id)->first()) {
            alert()->error('Este registro no se puede eliminar', 'Error');
            return back();
        } else {*/
            $antecedentemedico->delete();
            //Alert::success('Eliminado correctamente')->persistent();
            //alert()->success('Registro Eliminado', 'Exitosamente')->toToast();
            Alert::success('Registro Eliminado', 'Exitosamente');
            return back();
        //}
        
    }
}
