<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Alert;
use App\User;
use App\Models\Tipopago;
use Auth;
use Carbon\Carbon;

class TipopagoController extends Controller
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

        $segment = 'tipopago_c';

        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar

        $tipopagos =  Tipopago::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);

        

        return view('tipopagos.index', compact('tipopagos', 'segment','buscador','dato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $segment = 'tipopago_c';

        return view('tipopagos.create', compact('segment'));
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
            'descripcion' => 'required|max:100|unique:tipopagos,descripcion'
        ], $messages);

        $tipopago = Tipopago::create($request->all());

        Alert::success('Tipo de Pago Creado', 'Exitosamente');
        return redirect()->route('tipopagos.edit', $tipopago->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tipopago $tipopago)
    {
       // $tipocontacto = Tipocontacto::find($id);
        $segment = 'tipopago_c';
        $show = 1;
        //Alert::toast('Toast Message', 'success');
        return view('tipopagos.edit', compact('segment','tipopago', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipopago $tipopago)
    {
        
        //$tipocontacto = Tipocontacto::find($id);
        //dd($plan);
        $show = 0;
        $segment = 'tipopago_c';

        return view('tipopagos.edit', compact('segment', 'tipopago','show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipopago $tipopago)
    {
        //$tipocontacto = Tipocontacto::find($id);

        $messages = [
            'descripcion.required' => 'El campo descripcion es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:100|unique:tipopagos,descripcion,' . $tipopago->id
        ], $messages);


  
        $tipopago->update($request->all());
  
        Alert::success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('tipopagos.edit', $tipopago->id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipopago $tipopago)
    {
        
        /*if(Cliente::where('plan_id', '=', $id)->first()) {
            alert()->error('Este registro no se puede eliminar', 'Error');
            return back();
        } else {*/
            $tipopago->delete();
            //Alert::success('Eliminado correctamente')->persistent();
            //alert()->success('Registro Eliminado', 'Exitosamente')->toToast();
            Alert::success('Registro Eliminado', 'Exitosamente');
            return back();
        //}
        
    }
}
