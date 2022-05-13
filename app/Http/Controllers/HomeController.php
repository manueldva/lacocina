<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

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
        return view('home', compact('segment', 'inactivos', 'totales'));
    }
}
