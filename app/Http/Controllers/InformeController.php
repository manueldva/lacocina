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
use App\Models\VentaDetalle;
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
            return view('informes.show1', compact('segment'));

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



    public function print1($clienteId, $fechadesde, $fechahasta)
    {
        
        $cliente = Cliente::with('persona:id,apellido,nombre')
        ->select('persona_id')
        ->where('id', $clienteId)->withMontoAdeudado($fechadesde,$fechahasta)->first();

        if(!$cliente){
            alert()->error('No se encontro el ID cliente', 'Error');
            return back();
            //return redirect()->route('informes.show', 1);   
        }

    
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
    
        $cantidadgeneral = 1500;
         
        $pdf = PDF::loadView('informes.print1', compact('ventas', 'fechadesde', 'fechahasta', 'cliente','cantidadgeneral'));
            //$pdf->setPaper('Legal', 'landscape'); --Portrait 

        return $pdf->setPaper('a4', 'Portrait')->stream($cliente->persona->apellido . '_' . $cliente->persona->nombre . '_'.now()->format('Y-m-d').'.pdf');
    }

}
