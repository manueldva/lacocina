<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use  App\Models\Venta;

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
        $ventasDelDia = Venta::where('pago',false)->whereDate('fecha', Carbon::today())->count();
        
        $clientesConMontoAdeudado = Cliente::withMontoAdeudado()
        ->having('monto_adeudado', '>', 0)
        ->count();

        return view('home', compact('segment', 'inactivos', 'totales','ventasDelDia','clientesConMontoAdeudado'));
    }
}
