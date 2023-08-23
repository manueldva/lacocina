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
        ->withCount('ventafechasNoEntregadas as entregado') // Cargar las Ventafechas no entregadas
        ->withCount('ventafechasTotal as aEntregar') // Cargar las Ventafechas no entregadas
        ->orderBy('fecha', 'desc')
        ->orderBy('id', 'desc')
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

        //dd($request->all());
        $messages = [
            'metodopago_id.required' =>'El campo Metodo de pago es obligatorio.'
            
        ];
        $validatedData = $request->validate([
            //'descripcion' => 'required|max:200|unique:establecimientos,descripcion',
            'metodopago_id' => 'required',
            'fecha' => 'required'
            //'numerodocumento' => 'max:20',
            //'fechanacimiento' => 'required'
            
            //'body' => 'required',
        ], $messages);
        
        /*$tieneRegistros = Venta::where('estado',1)->where('cliente_id',$request->cliente_id)->count();  

        if ( $tieneRegistros > 0 ) {
            alert()->error('Error', 'Este cliente tiene una venta sin cerrar');
            return back();
        }*/

        $venta = new Venta;
            //$cliente->tipocliente_id = $request->input('tipocliente_id');
            $venta->cliente_id =  $request->cliente_id;
            $venta->tipopago_id = $request->tipopago_id;
            $venta->metodopago_id = $request->metodopago_id;
            $venta->fecha = $request->fecha;
                $venta->total = $request->total ?? 0;
                $venta->totalpagado = $request->totalpagado ?? 0;
            $venta->estado = true; //$request->has('estado') ? true : false;
            $venta->pago = $request->has('pago') ? true : false;
            $venta->otros = $request->has('otros') ? true : false;
            $venta->observaciones = $request->observaciones ?? '';
        $venta->save();


         // Actualizar los registros de ClienteVianda asociados al cliente
        $viandas = $request->input('viandas', []);
        //$total = 0;

        
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

                //$total += $cantidad * $precio;
            }
        } 

        if ($venta->otros == true){
            $idotros = Vianda::where('descripcion', 'Otros')->pluck('id')->first();
            $ventadetalle = new VentaDetalle();
                $ventadetalle->venta_id = $venta->id;
                $ventadetalle->vianda_id = $idotros;
                $ventadetalle->cantidad = 1;
                $ventadetalle->precio = 0;
            $ventadetalle->save();
        }


        // Actualizar el campo total de la venta
        /*$venta->total = $total;
        $venta->save();*/
        $dias = $request->has('otros') ? 1 : MetodoPago::where('id', $request->metodopago_id)->pluck('dias')->first() ;
        $fechaInicio = $request->fecha;

    
        $fechaObj = new \DateTime($fechaInicio);
    
        for ($i = 0; $i < $dias; $i++) {
            $nuevaFecha = $fechaObj->format('Y-m-d');
    
            $diaSemana = $fechaObj->format('w');

            if (!in_array($diaSemana, [0, 6])) {
            // Insertar el registro en la tabla Ventafecha
                $ventafecha = new Ventafecha();
                    $ventafecha->venta_id = $venta->id;
                    $ventafecha->fecha = $nuevaFecha;
                    $ventafecha->envio = $request->has('envio') ? true : false;
                    $ventafecha->entregado = false;
                $ventafecha->save();
            } else {
                $dias++;
            }
            // Incrementar la fecha en un día
            $fechaObj->add(new \DateInterval('P1D'));
        }



        alert()->success('Venta Creada', 'Exitosamente');
        return redirect()->route('ventas.edit', $venta->id);
        //return redirect()->route('ventas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        $segment = 'ventas';
       $show = 1;

       $tipopagos = Tipopago::where('activo',1)->get();

       $ventadetalles = Ventadetalle::where('venta_id',$venta->id)->get();

       $ventafechas = Ventafecha::where('venta_id',$venta->id)
       ->where('entregado',0)
       ->take('5')
       ->orderBy('fecha', 'desc') // Ordenar por la fecha en orden descendente
       ->get();

       $ultimaFechatemp = Ventafecha::where('venta_id', $venta->id)
        ->orderBy('fecha') // Ordenar por la fecha en orden descendente
        ->pluck('fecha')
        ->first();

        $ultimaFecha = Carbon::parse($ultimaFechatemp)->isoFormat('dddd D [de] MMMM'); // Formatear la fecha


       $totalRegistrosRestantes = max(
            Ventafecha::where('venta_id', $venta->id)
                ->where('entregado', 0)
                ->count() - 5,
            0
        );
        

       return view('ventas.edit', compact('venta', 'segment','tipopagos','ventadetalles','ventafechas','totalRegistrosRestantes', 'ultimaFecha', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {

       //$fecha = date('Y-m-d'); 
       $segment = 'ventas';
       $show = 0;

       $tipopagos = Tipopago::where('activo',1)->get();

       $ventadetalles = Ventadetalle::where('venta_id',$venta->id)->get();

       
       $ventafechas = Ventafecha::where('venta_id',$venta->id)
       ->where('entregado',0)
       ->take('5')
       ->orderBy('fecha') // Ordenar por la fecha en orden descendente
       ->get();

        $ultimaFechatemp = Ventafecha::where('venta_id', $venta->id)
        ->orderBy('fecha', 'desc') // Ordenar por la fecha en orden descendente
        ->pluck('fecha')
        ->first();

        $ultimaFecha = Carbon::parse($ultimaFechatemp)->isoFormat('dddd D [de] MMMM'); // Formatear la fecha

       $ultimaFecha = Ventafecha::where('venta_id', $venta->id)
        ->orderBy('fecha', 'desc') // Ordenar por la fecha en orden descendente
        ->pluck('fecha')
        ->first();

       $totalRegistrosRestantes = max(
            Ventafecha::where('venta_id', $venta->id)
                ->where('entregado', 0)
                ->count() - 5,
            0
        );
        

       return view('ventas.edit', compact('venta', 'segment','tipopagos','ventadetalles','ventafechas','totalRegistrosRestantes', 'ultimaFecha', 'show'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //dd($request->all());
        $estado = $request->estadoVal;//$request->has('estado') ? false : true;
        $pago = $request->has('pago') ? true : false;
       

        if ($estado == 0 && $pago == false) {
            alert()->error('Error', 'Debe seleccionar un tipo de pago para cerrar la venta');
            return back();
        }

        Venta::where('id', $venta->id)->update(['estado' => $estado, 'pago'=>$pago, 'tipopago_id' => $request->tipopago_id, 'total'=>  $request->total,'totalpagado'=>  $request->totalpagado]);
  
        alert()->success('Registro Actualizado', 'Exitosamente');
        return redirect()->route('ventas.edit', $venta->id);  
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        
        /*if(Venta::where('cliente_id', '=', $cliente->id)->first()) {
            alert()->error('Este registro no se puede eliminar', 'Error');
            return back();
        }*/
        // Eliminar los registros de ClienteVianda asociados al cliente
        Ventafecha::where('venta_id', $venta->id)->delete();
        VentaDetalle::where('venta_id', $venta->id)->delete();
        $venta->delete();
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


    public function actualizarEntregado(Request $request)
    {
        $id = $request->input('ventaf_id');
        $entregado = $request->input('entregado');
        $envio = $request->input('envio');
        $cancelar = $request->input('cancelar');
        $eliminar = $request->input('eliminar');

        // Convertir el valor 'entregado' a booleano
        $entregado = filter_var($entregado, FILTER_VALIDATE_BOOLEAN);
        $envio = filter_var($envio, FILTER_VALIDATE_BOOLEAN);
        $cancelar = filter_var($cancelar, FILTER_VALIDATE_BOOLEAN);
        $cancelar = filter_var($cancelar, FILTER_VALIDATE_BOOLEAN);

        // Si se desea cancelar
        if ($cancelar) {
            $venta_id = Ventafecha::where('id', $id)
            ->pluck('venta_id')
            ->first();

            $ultimaFecha = Ventafecha::where('venta_id', $venta_id)
            ->orderBy('fecha', 'desc') // Ordenar por la fecha en orden descendente
            ->pluck('fecha')
            ->first();

            // Convertir la fecha a un objeto Carbon
            $carbonFecha = Carbon::parse($ultimaFecha);
            
            // Verificar si el día de la semana es viernes (5)
            if ($carbonFecha->dayOfWeek === Carbon::FRIDAY) {
                // Sumar 3 días a la fecha si es viernes
                $carbonFecha->addDays(3);
            } else {
                // Sumar 1 día a la fecha si no es viernes
                $carbonFecha->addDay(1);
            }

            // Actualizar el campo 'fecha' en la base de datos
            Ventafecha::where('id', $id)->update(['entregado' => $entregado, 'envio' => $envio, 'fecha' => $carbonFecha]);
        
        } elseif($eliminar) {
            // Actualizar el campo 'entregado' en la base de datos sin modificar la fecha
            Ventafecha::where('id', $id)->delete();
        }
        else {
            // Actualizar el campo 'entregado' en la base de datos sin modificar la fecha
            Ventafecha::where('id', $id)->update(['entregado' => $entregado, 'envio' => $envio]);
        }



        // Actualizar el campo 'entregado' en la base de datos
        //Ventafecha::where('id', $id)->update(['entregado' => $entregado, 'envio'=>$envio]);

        return response()->json(['success' => true]);
    }



    public function detallesVenta($id)
    {
        $ventaDetalles = VentaDetalle::where('venta_id', $id)->with('vianda')->get();
        $ventaFechas = Ventafecha::where('venta_id', $id)->orderby('fecha')->get();
        $otros = Venta::where('id', $id)->pluck('observaciones')->first();
        $otros = $otros == '' ? '(Sin detalle)' : '(' . $otros . ')';
        $result = [];

        foreach ($ventaFechas as $ventaFecha) {
            $detallesTexto = $ventaDetalles->pluck('cantidad', 'vianda.descripcion')->map(function ($cantidad, $descripcion) use ($id) {
                if($descripcion == 'Otros') {
                    $otros = Venta::where('id', $id)->pluck('observaciones')->first();
                    $otros = $otros == '' ? '(Sin detalle)' : '(' . $otros . ')';
                    $descripcion =   $descripcion . $otros;
                }
                return "$cantidad $descripcion";
            })->implode(', ');

            $ventaFecha['detallesTexto'] =  $detallesTexto;


            $result[] = $ventaFecha;
        }

        return response()->json(['fechas' => $result]);
    }

}
