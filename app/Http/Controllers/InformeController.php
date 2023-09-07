<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Models\Ventafecha;
use Auth;
use Carbon\Carbon;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InformeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:informes.index')->only('index');
        $this->middleware('can:informes.show')->only('show');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segment = 'informes';

        return view('informes.index',compact( 'segment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $segment = 'informes';

        if($id == 1) { // ventas por repartidor

            $clientes = Cliente::join('personas', 'clientes.persona_id', '=', 'personas.id')
            ->select('clientes.id', 'personas.Apellido', 'personas.Nombre')
            ->get();


            return view('informes.show1', compact('segment','clientes'));

        } elseif($id == 2) { // informe diario de ventas
           
            return view('informes.show2', compact('segment'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    /*public function print1($clienteId, $fechadesde, $fechahasta, $tipo)
    {
        
        $cliente = Cliente::with('persona:id,apellido,nombre')
        ->select('persona_id')
        ->where('id', $clienteId)->MontoAdeudado()->first();
    
        $ventas = Venta::with([
            'tipoPago:id,descripcion',
            'cliente.persona:id,apellido,nombre'
        ])
        ->select('id', 'total', 'totalpagado', 'tipopago_id', 'fecha', 'cliente_id','pago')
        ->withCount('ventaDetalles as cantidadviandas')
        ->where('cliente_id', $clienteId)
        ->when($fechadesde, function ($query, $fechadesde) {
            return $query->where('fecha', '>=', $fechadesde);
        })
        ->when($fechahasta, function ($query, $fechahasta) {
            return $query->where('fecha', '<=', $fechahasta);
        })
        ->orderBy('fecha', 'DESC')
        ->get();
    
        $cantidadgeneral = Cliente::where('id', $clienteId)->MontoAdeudado()->value('deuda');
         
        $pdf = PDF::loadView('informes.print1', compact('ventas', 'fechadesde', 'fechahasta', 'cliente','cantidadgeneral', 'tipo'));
            //$pdf->setPaper('Legal', 'landscape'); --Portrait 

        return $pdf->setPaper('a4', 'Portrait')->stream($cliente->persona->apellido . '_' . $cliente->persona->nombre . '_'.now()->format('Y-m-d').'.pdf');
    }*/

    public function print1($clienteId, $fechadesde, $fechahasta, $tipo)
    {
        $cliente = Cliente::with('persona:id,apellido,nombre')
            ->select('persona_id')
            ->where('id', $clienteId)->MontoAdeudado()->first();

        $ventas = Venta::with([
            'tipoPago:id,descripcion',
            'cliente.persona:id,apellido,nombre'
        ])
        ->select('id', 'total', 'totalpagado', 'tipopago_id', 'fecha', 'cliente_id','pago','estado')
        ->withCount('ventaDetalles as cantidadviandas')
        ->withCount('ventafechasTotal as dias')
        ->where('cliente_id', $clienteId)
        ->where(function ($query) use ($tipo) { // filtro para traer solo los registros que todavia no se pagan
            if ($tipo == 1) {
                $query->where('estado', 1);
            }
        });

        if ($tipo == 0) { // agregar filtro de fechas si es el informe del modulo informes
            $ventas->when($fechadesde, function ($query, $fechadesde) {
                return $query->where('fecha', '>=', $fechadesde);
            })
            ->when($fechahasta, function ($query, $fechahasta) {
                return $query->where('fecha', '<=', $fechahasta);
            });
        } 


        $ventas = $ventas->orderBy('fecha', 'DESC')->get();

        //dd($ventas);

        $cantidadgeneral = Cliente::where('id', $clienteId)->MontoAdeudado()->value('deuda');

        $pdf = PDF::loadView('informes.print1', compact('ventas', 'fechadesde', 'fechahasta', 'cliente','cantidadgeneral', 'tipo'));
        
        //return $pdf->setPaper('a4', 'Portrait')->download($cliente->persona->apellido . '_' . $cliente->persona->nombre . '_'.now()->format('Y-m-d').'.pdf');
        return $pdf->setPaper('a4', 'Portrait')->stream($cliente->persona->apellido . '_' . $cliente->persona->nombre . '_'.now()->format('Y-m-d').'.pdf');
    }


    public function print2($fecha)
    {
        $ventas = Ventafecha::where('fecha', $fecha)
        ->with([
            'venta.cliente.persona:id,apellido,nombre',
            'venta.ventafechas:venta_id,envio,entregado',
        ])
        ->select('ventafechas.venta_id', 'ventas.observaciones', 'ventas.cliente_id') // Agrega 'cliente_id' a la selección si es necesario
        ->get();


        //dd($ventas);

        $pdf = PDF::loadView('informes.print2', compact('ventas', 'fecha'));

        return $pdf->setPaper('a4', 'Portrait')->stream('Informe_ventrega_por_fecha_' . $fecha.'.pdf');
    }


}
