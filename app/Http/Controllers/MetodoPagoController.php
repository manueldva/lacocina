<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Alert;
use App\User;
use App\Models\MetodoPago;
use App\Models\Cliente;
use Auth;
use Carbon\Carbon;

class MetodoPagoController extends Controller
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

        $segment = 'metodopagos_c';

        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar

        $metodopagos =  MetodoPago::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);

        

        return view('metodopagos.index', compact('metodopagos', 'segment','buscador','dato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segment = 'metodopagos_c';

        return view('metodopagos.create', compact('segment'));
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
            'descripcion' => 'required|max:100|unique:metodopagos,descripcion',
            'dias' => 'required|min:0',
            'aviso' => 'required|min:0' 
        ], $messages);

        $metodopago = MetodoPago::create($request->all());

        Alert::success('Metodo de pago Creado', 'Exitosamente');
        return redirect()->route('metodopagos.edit', $metodopago->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MetodoPago $metodopago)
    {
       // $tipocontacto = Tipocontacto::find($id);
        $segment = 'metodopagos_c';
        $show = 1;
        //Alert::toast('Toast Message', 'success');
        return view('metodopagos.edit', compact('segment','metodopago', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MetodoPago $metodopago)
    {
        
        //$tipocontacto = Tipocontacto::find($id);
        //dd($plan);
        $show = 0;
        $segment = 'metodopagos_c';

        return view('metodopagos.edit', compact('segment', 'metodopago','show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MetodoPago $metodopago)
    {
        //$tipocontacto = Tipocontacto::find($id);

        $messages = [
            'descripcion.required' => 'El campo descripcion es obligatorio.',
            'dias.required' => 'El campo Cantidad de dias es obligatorio.',
            'aviso.required' => 'El campo Aviso es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            'descripcion' => 'required|max:100|unique:metodopagos,descripcion,' . $metodopago->id,
            'dias' => 'required|min:0',
            'aviso' => 'required|min:0' 
        ], $messages);


  
        $metodopago->update($request->all());
  
        Alert::success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('metodopagos.edit', $metodopago->id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MetodoPago $metodopago)
    {
        if (Cliente::where('metodopago_id', '=', $metodopago->id)->first()) {
            Alert::error('Este registro no se puede eliminar', 'Error');
            return back();

        }
        /*if(Cliente::where('plan_id', '=', $id)->first()) {
            alert()->error('Este registro no se puede eliminar', 'Error');
            return back();
        } else {*/
            $metodopago->delete();
            //Alert::success('Eliminado correctamente')->persistent();
            //alert()->success('Registro Eliminado', 'Exitosamente')->toToast();
            Alert::success('Registro Eliminado', 'Exitosamente');
            return back();
        //}
        
    }
}
