<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Alert;
use App\User;
use App\Models\Tipocontacto;
use Auth;
use Carbon\Carbon;

class TipocontactoController extends Controller
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

        $segment = 'tipocontacto_c';

        $tipocontactos =  Tipocontacto::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);

        

        return view('tipocontactos.index', compact('tipocontactos', 'segment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $segment = 'tipocontacto_c';

        return view('tipocontactos.create', compact('segment'));
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
            'descripcion.required' => 'El campo descripcion completo es obligatorio.',
 
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:256|unique:tipocontactos,descripcion'
        ], $messages);

        $tipocontacto = Tipocontacto::create($request->all());

        Alert::success('Tipo de Contacto Creado', 'Exitosamente');
        return redirect()->route('tipocontactos.edit', $tipocontacto->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tipocontacto $tipocontacto)
    {
       // $tipocontacto = Tipocontacto::find($id);
        $segment = 'tipocontacto_c';
        $show = 1;
        //Alert::toast('Toast Message', 'success');
        return view('tipocontactos.edit', compact('segment','tipocontacto', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipocontacto $tipocontacto)
    {
        
        //$tipocontacto = Tipocontacto::find($id);
        //dd($plan);
        $show = 0;
        $segment = 'tipocontacto_c';

        return view('tipocontactos.edit', compact('segment', 'tipocontacto','show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipocontacto $tipocontacto)
    {
        //$tipocontacto = Tipocontacto::find($id);

        $messages = [
            'descripcion.required' => 'El campo descripcion completo es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:256|unique:tipocontactos,descripcion,' . $tipocontacto->id
        ], $messages);


  
        $tipocontacto->update($request->all());
  
        Alert::success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('tipocontactos.edit', $tipocontacto->id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipocontacto $tipocontacto)
    {
        
        /*if(Cliente::where('plan_id', '=', $id)->first()) {
            alert()->error('Este registro no se puede eliminar', 'Error');
            return back();
        } else {*/
            $tipocontacto->delete();
            //Alert::success('Eliminado correctamente')->persistent();
            //alert()->success('Registro Eliminado', 'Exitosamente')->toToast();
            Alert::success('Registro Eliminado', 'Exitosamente');
            return back();
        //}
        
    }
}
