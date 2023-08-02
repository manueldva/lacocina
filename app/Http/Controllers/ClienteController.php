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
use Auth;
use Carbon\Carbon;


class ClienteController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:clientes.index')->only('index');
        $this->middleware('can:clientes.create')->only('create','store');
        $this->middleware('can:clientes.edit')->only('edit','update');
        $this->middleware('can:clientes.show')->only('show');
        $this->middleware('can:clientes.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $segment = 'clientes';
        //$clientes = Cliente::paginate(10);
        $buscador = $request->get('tipo'); // se agrega para que queden seleccionados los filtros al recargar la pagina
        $dato = $request->get('buscarpor'); // despues ver como refactorizar
        
        //$clientes =  Cliente::buscarpor($request->get('tipo'), $request->get('buscarpor'))->paginate(10);
        
        $clientes = Cliente::buscarpor($request->get('tipo'), $request->get('buscarpor'))
        ->withMontoAdeudado()
        ->paginate(10);

        return view('clientes.index',compact('clientes', 'segment','buscador','dato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$fecha = date('Y-m-d'); 
        $segment = 'clientes';

        //$tipoclientes = Tipocliente::where('activo',1)->get();
        //$tipocontactos = Tipocontacto::where('activo',1)->get();
        $metodopagos = MetodoPago::where('activo',1)->get();
        $viandas = Vianda::where('activo', 1)->get();

        //$dias = Dia::where('activo',1)->get();

        return view('clientes.create', compact('segment','metodopagos','viandas'));
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
        // Eliminar los registros de ClienteVianda asociados al cliente
        ClienteVianda::where('cliente_id', $cliente->id)->delete();

        $cliente->delete();
        Persona::where('id', $cliente->persona_id)->delete();
        alert()->success('Registro Eliminado', 'Exitosamente');
        return back();
    }

    public function cargarViandas(Cliente $cliente)
    {
         //$miembro = Miembro::find($id);
        $show = 0;
        $segment = 'clientes';
 
         //$tipoclientes = Tipocliente::where('activo',1)->get();
        $tipopagos = TipoPago::where('activo',1)->get();
         //$dias = Dia::where('activo',1)->get();
        $viandas = Vianda::where('activo', 1)->get();
 
        $viandasSeleccionadas = $cliente->viandas()->pluck('vianda_id')->toArray();
 
        // Obtener las cantidades de las viandas relacionadas y calcular el monto total
        $cantidades = [];
        $montoTotal = 0;
        foreach ($cliente->viandas as $vianda) {
            $cantidad = $vianda->pivot->cantidad;
            $cantidades[$vianda->vianda_id] = $cantidad;
            $montoTotal += $vianda->precio * $cantidad;
        }

        $ventasDelDia = Venta::where('cliente_id',$cliente->id)->whereDate('fecha', Carbon::today())->paginate(5);

        $detallesDeVentas = [];
        foreach ($ventasDelDia as $venta) {
            $detalles = VentaDetalle::where('venta_id', $venta->id)->paginate(10);
            $detallesDeVentas[$venta->id] = $detalles;
        }
        
        
        
        //dd($montoTotal);
        return view('clientes.cargar', compact('cliente', 'segment','tipopagos','viandas','viandasSeleccionadas','ventasDelDia', 'detallesDeVentas','cantidades','montoTotal', 'show'));
    }



    public function guardarViandas(Request $request, Cliente $cliente)
    {
        
         //dd($request->all());
        $messages = [
            'tipopago_id.required' =>'El campo Tipo de pago es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            //'descripcion' => 'required|max:200|unique:establecimientos,descripcion',
            'tipopago_id' => 'required',
            'fecha' => 'required'
            //'numerodocumento' => 'max:20',
            //'fechanacimiento' => 'required'
            
            //'body' => 'required',
        ], $messages);
        
        
        $venta = new Venta;
            //$cliente->tipocliente_id = $request->input('tipocliente_id');
            $venta->cliente_id = $cliente->id;
            $venta->tipopago_id = $request->tipopago_id;
            $venta->fecha = $request->fecha;
            $venta->totalpagado = $request->totalpagado ?? 0;
            $venta->envio = $request->has('envio') ? true : false;
            $venta->pago = $request->has('pago') ? true : false;
        $venta->save();


         // Actualizar los registros de ClienteVianda asociados al cliente
        $viandas = $request->input('viandas', []);
        $total = 0;

        
         // Crear nuevos registros de ClienteVianda
        
        if ($viandas) {
             foreach ($viandas as $viandaId) {
                $cantidad = $request->input('cantidad_' . $viandaId, 0);
                $precio = Vianda::where('id', $viandaId)->pluck('precio')->first();
                $ventadetalle = new VentaDetalle();
                    $ventadetalle->venta_id = $venta->id;
                    $ventadetalle->vianda_id = $viandaId;
                    $ventadetalle->cantidad = $cantidad;
                    $ventadetalle->precio = $precio;
                $ventadetalle->save();

                $total += $cantidad * $precio;
            }
        }
        

        // Actualizar el campo total de la venta
        $venta->total = $total;
        $venta->save();

        alert()->success('Venta Creada', 'Exitosamente');
        return redirect()->route('clientes.index');

    }


    public function ventasDelCliente($clienteId)
    {
        /*$ventas = Venta::with('tipoPago:id,descripcion')
            ->select('id', 'total', 'totalpagado', 'tipopago_id', 'fecha')
            ->withCount('ventaDetalles as cantidadviandas')
            ->where('cliente_id', $clienteId)
            ->orderby('fecha','DESC')
            ->paginate(5); // Paginar 5 registros por página (puedes ajustar este número)*/
        $ventas = Venta::with([
            'tipoPago:id,descripcion',
            'cliente.persona:id,apellido,nombre'
        ])
        ->select('id', 'total', 'totalpagado', 'tipopago_id', 'fecha', 'cliente_id','pago')
        ->withCount('ventaDetalles as cantidadviandas')
        ->where('cliente_id', $clienteId)
        ->when(request()->input('fechaDesde'), function ($query, $fechaDesde) {
            return $query->where('fecha', '>=', $fechaDesde);
        })
        ->when(request()->input('fechaHasta'), function ($query, $fechaHasta) {
            return $query->where('fecha', '<=', $fechaHasta);
        })
        ->orderBy('fecha', 'DESC')
        ->paginate(5);
    
        $cliente = Cliente::with('persona:id,apellido,nombre')
            ->select('persona_id')
            ->where('id', $clienteId)->first();

        return response()->json([
            'ventas' => $ventas->items(),
            'currentPage' => $ventas->currentPage(),
            'lastPage' => $ventas->lastPage(),
            'cliente'=>  $cliente
        ]);
    }

}


