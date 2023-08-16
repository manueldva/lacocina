<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use  App\Models\Venta;
use  App\Models\Ventafecha;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $segment = 'home';

        $inactivos = Cliente::where('activo', false)->count();
        $totales = Cliente::count();
        $ventasDelDia = Ventafecha::whereDate('fecha', Carbon::today())->count();
        
        /*$clientesConMontoAdeudado = Cliente::withMontoAdeudado()
        ->having('monto_adeudado', '>', 0)
        ->count();*/

        // Obtener todas las ventas
        $ventas = Venta::where('estado',1)->get();

        $ventasConAviso = 0;

        // Recorrer las ventas
        foreach ($ventas as $venta) {

            $EntregaFaltanteCount = $venta->ventafechas()->where('entregado', 0)->count();

            if ($EntregaFaltanteCount) {
            
                if ($EntregaFaltanteCount <= $venta->metodoPago->aviso) {
                    $ventasConAviso++;
                }
            }
        }
    


        return view('home', compact('segment', 'inactivos', 'totales','ventasDelDia','ventasConAviso'));
    }


    public function mostrarVencimientos()
    {
         
        $segment = 'home';

        // Obtener la fecha actual
         $fechaActual = Carbon::now();

         // Obtener todas las ventas
         $ventas = Venta::where('estado',1)->get();
 
         $ventasConAviso = [];
 
         // Recorrer las ventas
         foreach ($ventas as $venta) {

            $EntregaFaltanteCount = $venta->ventafechas()->where('entregado', 0)->count();

            if ($EntregaFaltanteCount) {
            
                if ($EntregaFaltanteCount <= $venta->metodoPago->aviso) {

                    $fechaTemp = Ventafecha::where('venta_id', $venta->id)
                    ->orderBy('fecha', 'desc') // Ordenar por la fecha en orden descendente
                    ->pluck('fecha')
                    ->first();

                    $fechaEntrega = Carbon::parse($fechaTemp);
                    
                    $mensaje = "https://web.whatsapp.com/send?phone=". $venta->cliente->persona->telefono."&text=Hola! Lo saludamos desde la Cocina, queríamos avisarle que el día  ". $fechaEntrega->format('Y-m-d') ." se realizara la ultima entrega de su compra actual. Recuerde renovar su pedido. Gracias";

                    $mensajeMovil = " https://wa.me/". $venta->cliente->persona->telefono."?text=Hola! Lo saludamos desde la Cocina, queríamos avisarle que el día  ". $fechaEntrega->format('Y-m-d') ." se realizara la ultima entrega de su compra actual. Recuerde renovar su pedido. Gracias";
                    $ventasConAviso[] = [
                         'cliente' => $venta->cliente->persona->apellido .' ' . $venta->cliente->persona->nombre , // Asumiendo que tienes un método en tu modelo Cliente para obtener el nombre completo
                         'ultima_fecha' => $fechaEntrega->format('Y-m-d'),
                         'telefono' => $venta->cliente->persona->telefono,
                         'aviso'=>$venta->metodoPago->aviso,
                         'mensaje'=> $mensaje,
                         'mensajeMovil'=>$mensajeMovil,
                     ];
                 }
             }
        }

        return view('home.vencimientos',compact('segment','ventasConAviso'));
    }


    
}
