<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
Use Alert;
use App\User;
use App\Models\Persona;
use App\Models\Cliente;
//use App\Models\Tipocliente;
use App\Models\MetodoPago;
use App\Models\Vianda;
use App\Models\Tipopago;
use App\Models\ClienteVianda;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Ventafecha;
use Auth;
use Carbon\Carbon;


class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:ventas.index')->only('index');
        $this->middleware('can:ventas.create')->only('create','store');
        $this->middleware('can:ventas.edit')->only('edit','update');
        $this->middleware('can:ventas.show')->only('show');
        $this->middleware('can:ventas.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $segment = 'ventas';
        //$clientes = Cliente::paginate(10);
        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar
        
        //$clientes =  Cliente::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);
        
        $ventas = Venta::buscarpor($request->get('tipo'), $request->get('buscarpor'))
        //->withMontoAdeudado()
        ->paginate(10);

        return view('ventas.index',compact('ventas', 'segment','buscador','dato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$fecha = date('Y-m-d'); 
        $segment = 'ventas';

        $clientes = Cliente::join('personas', 'clientes.persona_id', '=', 'personas.id')
        ->select('clientes.id','clientes.metodopago_id', 'personas.Apellido', 'personas.Nombre')
        ->where('clientes.activo',1)
        ->get();

       //dd($clientes);

        $metodopagos= MetodoPago::where('activo',1)->get();

        $tipopagos = Tipopago::where('activo',1)->get();
        $viandas = Vianda::where('activo', 1)->get();



        //$dias = Dia::where('activo',1)->get();

        return view('ventas.create', compact('segment','metodopagos','viandas','clientes','tipopagos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        dd($request->all());

        $messages = [
            'fechanacimiento.required' =>'El campo Fecha de nacimiento es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            //'descripcion' => 'required|max:200|unique:establecimientos,descripcion',
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'documento' => 'max:20',
            'telefono' => 'max:20',
            'email' => 'max:150',
            'otrocontacto' => 'max:300',
            'metodopago_id' => 'required',
            'domicilio' => 'max:200'
            //'tipocliente_id' => 'required',
            //'numerodocumento' => 'max:20',
            //'fechanacimiento' => 'required'
            
            //'body' => 'required',
        ], $messages);
        
        /*if ($request->fechanacimiento >= now()->toDateString()) {
            alert()->error('Error', 'La fecha de nacimiento no puede ser mayor a la fecha actual');
            return back()->withInput();
        }*/

        $existe = Persona::where('apellido',$request->apellido)->where('nombre', $request->nombre)->count();

        //dd($existe);

        if($existe > 0) 
        {
            alert()->error('Error', 'Ya existe un cliente con ese apellido y nombre');
            return back()->withInput();
        }


        $persona = Persona::create($request->all());
        
        $cliente = new Cliente;
            //$cliente->tipocliente_id = $request->input('tipocliente_id');
            $cliente->persona_id = $persona->id;
            $cliente->metodopago_id = $request->metodopago_id;
        $cliente->save();


        // Obtener las viandas seleccionadas y las cantidades ingresadas
        $viandas = $request->input('viandas');
        $cantidades = $request->except('_token', 'viandas');

        // Procesar los datos y guardarlos en tu lógica de negocio
        if ($viandas) {
            foreach ($viandas as $vianda) {
                $cantidad = $cantidades['cantidad_'.$vianda];
                // Aquí puedes realizar las operaciones necesarias con la vianda y la cantidad
                // Guardar en la base de datos, hacer cálculos, etc.
                $clienteVianda = new ClienteVianda();
                    $clienteVianda->cliente_id = $cliente->id;
                    $clienteVianda->vianda_id = $vianda;
                    $clienteVianda->cantidad = $cantidad;
                $clienteVianda->save();
            }

        } 
          

        alert()->success('Cliente Creado', 'Exitosamente');
        return redirect()->route('clientes.edit', $cliente->id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        $segment = 'clientes';
        $show = 1;
        $metodopagos = MetodoPago::where('activo',1)->get();
        //Alert::toast('Toast Message', 'success');
        return view('clientes.edit', compact('segment','cliente', 'show','metodopagos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {

        //$miembro = Miembro::find($id);
        $show = 0;
        $segment = 'clientes';

        //$tipoclientes = Tipocliente::where('activo',1)->get();
        $metodopagos = MetodoPago::where('activo',1)->get();
        //$dias = Dia::where('activo',1)->get();
        $viandas = Vianda::where('activo', 1)->get();

        $viandasSeleccionadas = $cliente->viandas()->pluck('vianda_id')->toArray();

        // Obtener las cantidades de las viandas relacionadas
        $cantidades = [];
        foreach ($cliente->viandas as $vianda) {
            $cantidades[$vianda->vianda_id] = $vianda->pivot->cantidad;
        }


        return view('clientes.edit', compact('cliente', 'segment','metodopagos','viandas','viandasSeleccionadas','cantidades', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        
        //dd($request->all());
        $messages = [
            'fechanacimiento.required' =>'El campo Fecha de nacimiento es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            //'descripcion' => 'required|max:200|unique:establecimientos,descripcion',
            'apellido' => 'required|max:100',
            'nombre' => 'required|max:100',
            'documento' => 'max:20',
            'telefono' => 'max:20',
            'email' => 'max:150',
            'otrocontacto' => 'max:300',
            'metodopago_id' => 'required',
            'domicilio' => 'max:200'
            //'tipocliente_id' => 'required',
            //'numerodocumento' => 'max:20',
            //'fechanacimiento' => 'required'
            
            //'body' => 'required',
        ], $messages);

        

        /*if ($request->fechanacimiento >= now()->toDateString()) {
            alert()->error('Error', 'La fecha de nacimiento no puede ser mayor a la fecha actual');
            return back();
        }*/


        $existe = Persona::where('apellido',$request->apellido)
                                ->where('nombre', $request->nombre)
                                ->where('id','<>', $cliente->persona_id)
                                ->count();

        //dd($existe);

        if($existe > 0) 
        {
            alert()->error('Error', 'Ya existe un cliente con ese apellido y nombre');
            return back()->withInput();
        }

  
        $cliente->update($request->all());
        $persona = Persona::find($cliente->persona_id);
        $persona->update($request->all());


        // Actualizar los registros de ClienteVianda asociados al cliente
        $viandas = $request->input('viandas', []);

    
        // Eliminar los registros existentes de ClienteVianda
        ClienteVianda::where('cliente_id', $cliente->id)->delete();

        // Crear nuevos registros de ClienteVianda

        if ($viandas) {
            foreach ($viandas as $viandaId) {
                $cantidad = $request->input('cantidad_' . $viandaId, 0);
                $clienteVianda = new ClienteVianda();
                    $clienteVianda->cliente_id = $cliente->id;
                    $clienteVianda->vianda_id = $viandaId;
                    $clienteVianda->cantidad = $cantidad;
                $clienteVianda->save();
            }
        }
  
        alert()->success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('clientes.edit', $cliente->id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        
        if(Venta::where('cliente_id', '=', $cliente->id)->first()) {
            alert()->error('Este registro no se puede eliminar', 'Error');
            return back();
        }
        // Eliminar los registros de ClienteVianda asociados al cliente
        ClienteVianda::where('cliente_id', $cliente->id)->delete();

        $cliente->delete();
        Persona::where('id', $cliente->persona_id)->delete();
        alert()->success('Registro Eliminado', 'Exitosamente');
        return back();
    }

    public function getClienteInfo($id)
    {
        $viandasSeleccionadas = Vianda::join('clienteviandas', 'viandas.id', '=', 'clienteviandas.vianda_id')
        ->where('clienteviandas.cliente_id', $id)
        ->pluck('clienteviandas.cantidad','viandas.id')
        ->toArray();

        return response()->json([
            'viandasSeleccionadas' => $viandasSeleccionadas  
        ]);
    }
}
